<?php

declare(strict_types=1);

namespace YiiDb\ActiveRecord\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class TableName
{
    public function __construct(public readonly string $tableName, public readonly ?string $databaseName = null)
    {
    }
}
