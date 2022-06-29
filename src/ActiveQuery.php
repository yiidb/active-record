<?php

declare(strict_types=1);

namespace YiiDb\ActiveRecord;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Query\QueryBuilder;
use YiiDb\ActiveRecord\Contracts\ActiveQueryInterface;
use YiiDb\ActiveRecord\Contracts\ActiveRecordInterface;
use YiiDb\ActiveRecord\Contracts\ActiveRecordManagerInterface;
use YiiDb\DBAL\Expressions\ExpressionBuilder;
use YiiDb\DBAL\Query;

/**
 * @template ARClass of ActiveRecordInterface
 */
class ActiveQuery extends Query implements ActiveQueryInterface
{
    protected readonly string $arClass;
    protected readonly ActiveRecordManagerInterface $arManager;
    protected readonly ActiveRecordMetaInfo $arMetaInfo;
    protected readonly AbstractPlatform $databasePlatform;

    private ?string $alias = null;

    /**
     * @param class-string<ARClass> $arClass
     *
     * @throws Exception
     */
    public function __construct(
        ActiveRecordManagerInterface $arManager,
        string $arClass
    ) {
        $this->arManager = $arManager;
        $this->arClass = $arClass;
        $this->arMetaInfo = $arManager->getMetaInfoByClass($arClass);
        $connection = $arManager->getConnectionByName($this->arMetaInfo->connectionName);
        $this->databasePlatform = $connection->getDatabasePlatform();

        parent::__construct($connection);
    }

    /**
     * @return ARClass|null
     *
     * @throws Exception
     */
    public function getFirst(): ?ActiveRecordInterface
    {
        $row = $this->prepareSelectQuery($this->createQueryBuilder())
            ->setMaxResults(1)
            ->fetchAssociative();

        $arClass = $this->arClass;
        /** @var ActiveRecordInterface $record */
        $record = new $arClass($this->arManager);
        $record->initFromRawValues($row);

        return $record;
    }

    protected function getTableName(): string
    {
        if ($database = ($this->arMetaInfo->databaseName)) {
            $database = $this->databasePlatform->quoteSingleIdentifier($database) . '.';
        }

        return $database . $this->databasePlatform->quoteSingleIdentifier($this->arMetaInfo->tableName);
    }

    private function prepareSelectQuery(QueryBuilder $query): QueryBuilder
    {
        $this->alias = 'u';

        $tableName = $this->getTableName();
        $tableAlias = $this->alias ?? $tableName;

        //$this->databasePlatform->quoteIdentifier();

//        $x = $this->expr()->and(
//            $x1 = $this->expr()->comparison('i', ExpressionBuilder::EQ, 55, ParameterType::INTEGER),
//            $x2 = $this->expr()->comparison('s', ExpressionBuilder::EQ, 'test')
//        );
//        $x = $x->with($this->expr()->in('id', [10, 15, 20]));
//        $x = $this->expr()->in('z', [$x]);
//        var_dump((string)$x, $x1, $x2);


        $x = $this->expr()->eq('name', $this->expr()->neqColumns('x', 'y'));
        $x = $this->expr()->not($x);
        $x2 = $this->expr()->not('test');
        var_dump((string)$x, (string)$x2);
//        $x = $this->expr()->and(
//            $this->expr()->comparisonColumns('a', ExpressionBuilder::EQ, 'b'),
//            $this->expr()->comparisonColumns('x.c', ExpressionBuilder::NEQ, 'x.d'),
//        );
//        $x = $x->with($this->expr()->comparisonColumns('e', ExpressionBuilder::LTE, 'f'));
//
//        var_dump($x, (string)$x);

        $query
            ->select($tableAlias . '.*')
            ->from($tableName, $this->alias)
            ->where('a=b')
            ->andWhere('c=d')
            ->andWhere('e=f');

        var_dump($query->getSQL());
        die();

        //var_dump($query->expr()->in('X', ['a', 'b', 'c']));
        var_dump((string)$query->expr()->and(
            $query->expr()->eq('username', '?'),
            $query->expr()->and(
                $query->expr()->eq('username', '?'),
                $query->expr()->eq('email', '?')
            )
        ));
        die();

        //$query->addSelect( );

        return $query;
//        $arMetaInfo = $this->arManager->getMetaInfoByClass($this->arClass);
//        //$query->createNamedParameter()
//        return $query->select('*')
//            ->from($arMetaInfo->tableName);
    }

    public function withAlias(string $alias = null): static
    {
        $alias = $alias ?: null;
        if ($this->alias === $alias) {
            return $this;
        }

        $new = clone $this;
        $new->alias = $alias;

        return $new;
    }
//    /**
//     * @return ARClass|null
//     * @psalm-return (ARClass&ActiveRecordInterface)|null
//     */
//    public function getFirst(): ?ActiveRecordInterface
//    {
//        $arClass = $this->arClass;
//        /** @psalm-suppress MixedMethodCall */
//        $result = new $arClass($this->arManager);
//        /** @var ARClass $result */
//        /** @psalm-var ARClass&ActiveRecordInterface $result */
//        return $result;
//    }
//
//    /**
//     * @return ARTest[]
//     * @psalm-return array<ARClass&ActiveRecordInterface>
//     */
//    public function getAllAsArray(): array
//    {
//        if ($model = $this->getFirst()) {
//            return [$model];
//        }
//
//        return [];
//    }
//
//    /**
//     * @return ActiveCollection<ARClass>
//     * @xpsalm-suppress LessSpecificImplementedReturnType
//     */
//    public function get(): ActiveCollection
//    {
//        return new ActiveCollection($this);
//    }
//
//    public function where(string|array $condition, array $params = []): static
//    {
//        return $this;
//    }
//
//    public function deleteAll(): int
//    {
//        return 0;
//    }
//
//    public function updateAll(array $attributes): int
//    {
//        return 0;
//    }
//
//    public function updateAllCounters(array $counters): int
//    {
//        return 0;
//    }
}
