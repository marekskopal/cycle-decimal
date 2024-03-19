<?php

declare(strict_types=1);

namespace MarekSkopal\Cycle\Decimal\Tests;

use Decimal\Decimal;
use MarekSkopal\Cycle\Decimal\DecimalTypecast;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

#[CoversClass(DecimalTypecast::class)]
class DecimalTypecastTest extends TestCase
{
    #[TestWith([
        [
            'price' => 'decimal(20,10)',
            'units' => 'decimal(18,8)',
            'value' => 'decimal(12,2)',
        ],
        [],
    ])]
    #[TestWith([
        [
            'dividendGainPercentage' => 'float',
            'dividendGainPercentagePerAnnum' => 'float',
        ],
        [
            'dividendGainPercentage' => 'float',
            'dividendGainPercentagePerAnnum' => 'float',
        ],
    ])]
    #[TestWith([
        [
            'price' => 'decimal(20,10)',
            'dividendGainPercentage' => 'float',
        ],
        [
            'dividendGainPercentage' => 'float',
        ],
    ])]
    public function testSetRules(array $rules, array $expected): void
    {
        $decimalTypecast = new DecimalTypecast();

        $this->assertSame($expected, $decimalTypecast->setRules($rules));
    }

    #[TestWith(['decimal', Decimal::DEFAULT_PRECISION, '1.2345678901'])]
    #[TestWith(['decimal(20,10)', 20, '1.2345678901'])]
    public function testCast(string $typecast, int $precision, string $value): void
    {
        $decimalTypecast = new DecimalTypecast();
        $decimalTypecast->setRules(['price' => $typecast]);

        $data = [
            'price' => $value,
        ];

        $cast = $decimalTypecast->cast($data);

        $this->assertIsArray($cast);
        $this->assertArrayHasKey('price', $cast);
        $this->assertInstanceOf(Decimal::class, $cast['price']);
        $this->assertSame($precision, $cast['price']->precision());
        $this->assertSame($value, $cast['price']->toString());
    }

    public function testUncast(): void
    {
        $decimalTypecast = new DecimalTypecast();
        $decimalTypecast->setRules(['price' => 'decimal(20,10)']);

        $data = [
            'price' => new Decimal('1.2345678901', 20),
        ];

        $uncast = $decimalTypecast->uncast($data);

        $this->assertIsArray($uncast);
        $this->assertArrayHasKey('price', $uncast);
        $this->assertIsString($uncast['price']);
        $this->assertSame('1.2345678901', $uncast['price']);
    }
}
