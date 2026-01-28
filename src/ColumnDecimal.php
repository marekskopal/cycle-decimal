<?php

declare(strict_types=1);

namespace MarekSkopal\Cycle\Decimal;

use Attribute;
use Cycle\Annotated\Annotation\Column;
use Spiral\Attributes\NamedArgumentConstructor;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
//@phpstan-ignore-next-line attribute.deprecated attribute.deprecatedClass
#[NamedArgumentConstructor]
class ColumnDecimal extends Column
{
    public function __construct(
        int $precision,
        int $scale,
        ?string $name = null,
        ?string $property = null,
        bool $primary = false,
        bool $nullable = false,
        mixed $default = null,
        bool $castDefault = false,
        bool $readonlySchema = false,
    ) {
        $type = DecimalTypecast::Type . '(' . $precision . ',' . $scale . ')';

        parent::__construct($type, $name, $property, $primary, $nullable, $default, $type, $castDefault, $readonlySchema);
    }
}
