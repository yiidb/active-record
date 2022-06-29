<?php

declare(strict_types=1);

namespace YiiDb\ActiveRecord\Contracts;

use Doctrine\DBAL\Connection;
use YiiDb\ActiveRecord\ActiveRecordMetaInfo;

interface ActiveRecordManagerInterface
{
    /**
     * @param class-string $class
     */
    public function getConnectionByClass(string $class): Connection;

    public function getConnectionByName(string $name = null): Connection;

    /**
     * @param class-string $class
     */
    public function getMetaInfoByClass(string $class): ActiveRecordMetaInfo;

    /**
     * @param list<string>|null $attributes
     */
    public function insert(ActiveRecordInterface $model, array $attributes = null): bool;
}
