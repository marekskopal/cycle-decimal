<?php

declare(strict_types=1);

namespace MarekSkopal\Cycle\Decimal;

use Cycle\Annotated\Annotation\Column;

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
        ...$attributes,
    ) {
        $type = DecimalTypecast::Type . '(' . $precision . ',' . $scale . ')';

        parent::__construct($type, $name, $property, $primary, $nullable, $default, $type, $castDefault, $readonlySchema, $attributes);
    }
}
