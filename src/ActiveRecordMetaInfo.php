<?php

declare(strict_types=1);

namespace YiiDb\ActiveRecord;

use Doctrine\DBAL\Schema\Column;

final class ActiveRecordMetaInfo
{
    /**
     * @var list<string>
     */
    public readonly array $columnNames;
    /**
     * @var array<string, mixed>
     */
    public readonly array $defaultValues;
    /**
     * @var array<string, string>
     */
    public readonly array $notNullColumns;

    /**
     * @param array<string, Column> $columns
     */
    public function __construct(
        public readonly string $tableName,
        public readonly ?string $databaseName,
        public readonly ?string $connectionName,
        public readonly array $columns
    ) {
        $columnNames = [];
        $defaultValues = [];
        $notNullColumns = [];
        foreach ($columns as $columnName => $column) {
            $columnNames[] = $columnName;
            if (($default = $column->getDefault()) !== null) {
                $defaultValues[$columnName] = $default;
            }
            if ($column->getNotnull() !== null) {
                $notNullColumns[$columnName] = $columnName;
            }
        }
        $this->columnNames = $columnNames;
        $this->defaultValues = $defaultValues;
        $this->notNullColumns = $notNullColumns;
    }
}
