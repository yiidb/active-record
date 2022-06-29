<?php

declare(strict_types=1);

namespace YiiDb\ActiveRecord;

use ArrayIterator;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use IteratorAggregate;
use LogicException;
use ReflectionClass;
use RuntimeException;
use Traversable;
use YiiDb\ActiveRecord\Attributes\ConnectionName;
use YiiDb\ActiveRecord\Attributes\MagicProperty;
use YiiDb\ActiveRecord\Attributes\TableName;
use YiiDb\ActiveRecord\Contracts\ActiveRecordInterface;
use YiiDb\ActiveRecord\Contracts\ActiveRecordManagerInterface;
use YiiDb\ActiveRecord\Exceptions\UndefinedPropertyException;

use function array_key_exists;

class ActiveRecord implements ActiveRecordInterface, IteratorAggregate
{
//    protected string $tableName;
//    /**
//     * @var list<string>
//     */
//    protected array $keys = ['id'];
//    protected bool $keyIsAutoIncrementing = true;
//    /**
//     * @var array<string, mixed>
//     */
//    protected array $defaultValues = [];
//    /**
//     * @var array<string, mixed>|null
//     */
//    protected ?array $attributes = null;
//    /**
//     * @var array<string, list<string>>
//     */
//    protected array $safeAttributes = [];
//    /**
//     * @var array<string, list<string>>
//     */
//    protected array $guardedAttributes = [];
//

    protected readonly ActiveRecordManagerInterface $arManager;
    protected readonly ActiveRecordMetaInfo $arMetaInfo;
    protected readonly AbstractPlatform $databasePlatform;

    /**
     * @var array<string, mixed>|null
     */
    private ?array $oldValues = null;
    private ActiveRecordState $state = ActiveRecordState::New;
    /**
     * @var array<string, mixed>|null
     */
    private ?array $values = null;

    /**
     * @throws Exception
     */
    public function __construct(ActiveRecordManagerInterface $arManager = null)
    {
        $this->arManager = $arManager ?? ActiveRecordManager::getGlobal();
        $this->arMetaInfo = $this->arManager->getMetaInfoByClass(static::class);
        $connection = $this->arManager->getConnectionByName($this->arMetaInfo->connectionName);
        $this->databasePlatform = $connection->getDatabasePlatform();
    }

    public function getARManager(): ActiveRecordManagerInterface
    {
        return $this->arManager;
    }

    /**
     * @return ActiveQuery<static>
     */
    public static function find(ActiveRecordManagerInterface $arManager = null): ActiveQuery
    {
        return new ActiveQuery($arManager ?? ActiveRecordManager::getGlobal(), static::class);
    }

//    /**
//     * @param array<string, mixed> $params
//     */
//    public static function deleteAll(
//        ActiveRecordManagerInterface $arManager,
//        array|string $condition = '',
//        array $params = []
//    ): int {
//        return static::find($arManager)->where($condition, $params)->deleteAll();
//    }
//
//    /**
//     * @param array<string, mixed> $attributes
//     * @param array<string, mixed> $params
//     */
//    public static function updateAll(
//        ActiveRecordManagerInterface $arManager,
//        array $attributes,
//        array|string $condition = '',
//        array $params = []
//    ): int {
//        return static::find($arManager)->where($condition, $params)->updateAll($attributes);
//    }
//
//    public static function updateAllCounters(
//        ActiveRecordManagerInterface $arManager,
//        array $counters,
//        array|string $condition = '',
//        array $params = []
//    ): int {
//        return static::find($arManager)->where($condition, $params)->updateAllCounters($counters);
//    }

    public function loadDefaultValues(bool $skipIfSet = true, array $attributes = null): static
    {
        // TODO: Implement loadDefaultValues() method.
        return $this;
    }

    public static function create(array $attributes = [], ActiveRecordManagerInterface $arManager = null): static
    {
        $obj = static::make($attributes, $arManager);

        if (!$obj->insert()) {
            throw new RuntimeException('Failed to create a record.');
        }

        return $obj;
    }

    public static function make(array $attributes = [], ActiveRecordManagerInterface $arManager = null): static
    {
        return (new static($arManager))->loadDefaultValues()->setValues($attributes);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->hasAttribute((string)$offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->getValue((string)$offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->setValue((string)$offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->setValue((string)$offset, null);
    }

    public function setValues(array $values): static
    {
        foreach ($values as $attrName => $value) {
            $this->setValue($attrName, $value);
        }

        return $this;
    }

    public function setValue(string $attribute, mixed $value): void
    {
        if (!array_key_exists($attribute, $this->arMetaInfo->columns)) {
            throw new UndefinedPropertyException(static::class, $attribute);
        }

        $this->values[$attribute] = $value;
    }

    public function insert(array $attributes = null): bool
    {
        if ($this->state !== ActiveRecordState::New) {
            throw new RuntimeException('The action is allowed only for new objects.');
        }
        // TODO: Implement insert() method.

        if ($result = $this->arManager->insert($this, $attributes)) {
            $this->state = ActiveRecordState::Loaded;
        }

        return $result;
    }

    public function getState(): ActiveRecordState
    {
        return $this->state;
    }

    public function setState(ActiveRecordState $state): static
    {
        $this->state = $state;

        return $this;
    }

    public static function getTableName(): TableName
    {
        $reflection = new ReflectionClass(static::class);
        foreach ($reflection->getAttributes(TableName::class) as $attr) {
            return $attr->newInstance();
        }

        $error = 'The "%s" class must override the getTableName method or have a TableName attribute.';
        throw new LogicException(sprintf($error, static::class));
    }

    public static function getConnectionName(): ?string
    {
        $reflection = new ReflectionClass(static::class);
        foreach ($reflection->getAttributes(ConnectionName::class) as $attr) {
            /** @var ConnectionName $attrInst */
            $attrInst = $attr->newInstance();
            return $attrInst->name ?: null;
        }

        return null;
    }

    /**
     * @return array<string, string>
     */
    public static function getMagicProperties(): array
    {
        static $properties = null;

        if ($properties === null) {
            $properties = [];
            $reflection = new ReflectionClass(static::class);
            foreach ($reflection->getAttributes(MagicProperty::class) as $attr) {
                /** @var MagicProperty $attrInst */
                $attrInst = $attr->newInstance();
                $properties[$attrInst->propertyName] = $attrInst->attributeName;
            }
        }

        return $properties;
    }

    public function __get(string $name): mixed
    {
        $attrs = static::getMagicProperties();
        if ($attrName = $attrs[$name] ?? null) {
            return $this->getValue($attrName);
        }

        throw new UndefinedPropertyException(static::class, $name);
    }

    public function __set(string $name, mixed $value): void
    {
        $attrs = static::getMagicProperties();
        if (!($attrName = $attrs[$name] ?? null)) {
            throw new UndefinedPropertyException(static::class, $name);
        }

        $this->setValue($attrName, $value);
    }

    public function __isset(string $name): bool
    {
        $attrs = static::getMagicProperties();
        if (!($attrName = $attrs[$name] ?? null)) {
            throw new UndefinedPropertyException(static::class, $name);
        }

        return isset($this->values[$attrName]);
    }

    public function __unset(string $name): void
    {
        $attrs = static::getMagicProperties();
        if (!($attrName = $attrs[$name] ?? null)) {
            throw new UndefinedPropertyException(static::class, $name);
        }

        $this->values[$attrName] = null;
    }

    public function getValue(string $attribute): mixed
    {
        if (array_key_exists($attribute, $this->values)) {
            $value = $this->values[$attribute];
            if ($value !== null) {
                $column = $this->arMetaInfo->columns[$attribute] ?? null;
                if ($column) {
                    //var_dump($column->getType()->convertToPHPValue($value, $this->platform));
                    $value = $column->getType()->convertToPHPValue($value, $this->databasePlatform);
                }
            }

            return $value;
        }

        if (!array_key_exists($attribute, $this->arMetaInfo->columns)) {
            throw new UndefinedPropertyException(static::class, $attribute);
        }

        return null;
    }

    public function getAttributes(): array
    {
        return $this->arMetaInfo->columnNames;
    }

    public function hasAttribute(string $attribute): bool
    {
        if (array_key_exists($attribute, $this->values)) {
            return true;
        }

        if (array_key_exists($attribute, $this->arMetaInfo->columns)) {
            return true;
        }

        return false;
    }

    public function initFromRawValues(array $values): void
    {
        $this->state = ActiveRecordState::Loaded;
        $this->values = $values;
        $this->oldValues = $values;
    }

    public function getValues(array $attributes = null): array
    {
        if ($attributes === null) {
            $attributes = array_keys($this->values);
        }

        $values = [];
        foreach ($attributes as $attribute) {
            $values[$attribute] = $this->getValue($attribute);
        }

        return $values;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->values);
        return new ArrayIterator($this->getValues());
    }
}
