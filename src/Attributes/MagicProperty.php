<?php

declare(strict_types=1);

namespace YiiDb\ActiveRecord\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final class MagicProperty
{
    public function __construct(public readonly string $propertyName, public readonly string $attributeName)
    {
    }
}
