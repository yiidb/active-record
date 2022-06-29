<?php

declare(strict_types=1);

namespace YiiDb\ActiveRecord\Exceptions;

use LogicException;
use Throwable;

final class UndefinedPropertyException extends LogicException
{
    public function __construct(string $className, string $propertyName)
    {
        parent::__construct(sprintf('Undefined property: %s::$%s', $className, $propertyName));
    }
}
