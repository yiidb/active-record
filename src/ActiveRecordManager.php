<?php

declare(strict_types=1);

namespace YiiDb\ActiveRecord;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Column;
use LogicException;
use RuntimeException;
use YiiDb\ActiveRecord\Contracts\ActiveRecordInterface;
use YiiDb\ActiveRecord\Contracts\ActiveRecordManagerInterface;
use YiiDb\DBAL\Contracts\ConnectionManagerInterface;

class ActiveRecordManager implements ActiveRecordManagerInterface
{
    protected readonly ConnectionManagerInterface $connectionManager;

    private static ?self $global = null;
    /**
     * @var array<class-string, ActiveRecordMetaInfo>
     */
    private array $metaInfoCache = [];

    public function __construct(ConnectionManagerInterface $connectionManager)
    {
        $this->connectionManager = $connectionManager;
    }

    public function getConnectionByClass(string $class): Connection
    {
        return $this->connectionManager->getConnection($this->getMetaInfoByClass($class)->connectionName);
    }

    public function getConnectionByName(string $name = null): Connection
    {
        return $this->connectionManager->getConnection($name);
    }

    public static function getGlobal(): ActiveRecordManagerInterface
    {
        if (!isset(self::$global)) {
            throw new RuntimeException('The global ActiveRecordManager is not registered.');
        }

        return self::$global;
    }

    final public function getMetaInfoByClass(string $class): ActiveRecordMetaInfo
    {
        return $this->metaInfoCache[$class]
            ?? ($this->metaInfoCache[$class] = $this->makeMetaInfoForClass($class));
    }

    public function insert(ActiveRecordInterface $model, array $attributes = null): bool
    {
        // TODO: Implement insert() method.
        return true;
    }

    public static function registerGlobal(Contracts\ActiveRecordManagerInterface $arm): void
    {
        self::$global = $arm;
    }

    public static function unregisterGlobal(): void
    {
        self::$global = null;
    }

    /**
     * @return array<string, Column>
     *
     * @throws Exception
     */
    private function getTableColumnList(?string $connectionName, string $tableName, ?string $databaseName): array
    {
        //TODO: Тут будет работа с кешем
        return $this->makeTableColumnList($connectionName, $tableName, $databaseName);
    }

    /**
     * @param class-string $class
     *
     * @throws Exception
     */
    private function makeMetaInfoForClass(string $class): ActiveRecordMetaInfo
    {
        if (!is_subclass_of($class, ActiveRecordInterface::class)) {
            $error = 'The "%s" class must support the ActiveRecordInterface interface.';
            throw new LogicException(sprintf($error, $class));
        }

        $connectionName = $class::getConnectionName();
        $tableName = $class::getTableName();

        $columns = $this->getTableColumnList($connectionName, $tableName->tableName, $tableName->databaseName);

        return new ActiveRecordMetaInfo($tableName->tableName, $tableName->databaseName, $connectionName, $columns);
    }

    /**
     * @return array<string, Column>
     *
     * @throws Exception
     */
    private function makeTableColumnList(?string $connectionName, string $tableName, ?string $databaseName): array
    {
        $connection = $this->connectionManager->getConnection($connectionName);
        $schemaManager = $connection->createSchemaManager();

        return $schemaManager->listTableColumns($tableName, $databaseName);
    }
}
