<?php

declare(strict_types=1);

use YiiDb\ActiveRecord\ActiveRecordManager;
use Yiisoft\Yii\Http\Event\ApplicationStartup;

/**
 * @var array $params
 */
if (!(bool)($params['yii/active-record']['registerGlobalActiveRecordManager'] ?? false)) {
    return [];
}

return [
    ApplicationStartup::class => [
        ActiveRecordManager::registerGlobal(...),
    ],
];
