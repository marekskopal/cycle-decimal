<?php

namespace FinGather\Tests;

use MarekSkopal\Cycle\Decimal\ColumnDecimal;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ColumnDecimal::class)]
class ColumnDecimalTest extends TestCase
{
    public function testConstruct(): void
    {
        $columnDecimal = new ColumnDecimal(12, 2);

        $this->assertEquals('decimal(12,2)', $columnDecimal->getType());
    }
}
