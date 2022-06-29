<?php

declare(strict_types=1);

use YiiDb\ActiveRecord\ActiveRecordManager;
use YiiDb\ActiveRecord\Contracts\ActiveRecordManagerInterface;

/**
 * @var array $params
 */
return [
    ActiveRecordManagerInterface::class => ActiveRecordManager::class,
    ActiveRecordManager::class => ActiveRecordManager::class,
];
