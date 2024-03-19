<?php

declare(strict_types=1);

namespace MarekSkopal\Cycle\Decimal;

use Cycle\ORM\Parser\CastableInterface;
use Cycle\ORM\Parser\UncastableInterface;
use Decimal\Decimal;

final class DecimalTypecast implements CastableInterface, UncastableInterface
{
    public const Type = 'decimal';

    /** @var array<string, int> */
    private array $rules = [];

    /**
     * @param array<non-empty-string, mixed> $rules
     * @return array<non-empty-string, mixed>
     */
    public function setRules(array $rules): array
    {
        foreach ($rules as $key => $rule) {
            if (is_string($rule) && str_starts_with($rule, self::Type)) {
                unset($rules[$key]);

                preg_match('/^' . self::Type . '(\((?<precision>[0-9]+),(?<scale>[0-9]+)\))?$/', $rule, $matches);

                $this->rules[$key] = ($matches['precision'] ?? null) !== null ? (int) $matches['precision'] : Decimal::DEFAULT_PRECISION;
            }
        }

        return $rules;
    }

    /**
     * @param array<mixed> $data
     * @return array<string, mixed>
     */
    public function cast(array $data): array
    {
        foreach ($this->rules as $column => $precision) {
            if (!isset($data[$column])) {
                continue;
            }

            $data[$column] = new Decimal($data[$column], $precision);
        }

        return $data;
    }

    /**
     * @param array<mixed> $data
     * @return array<string, mixed>
     */
    public function uncast(array $data): array
    {
        foreach ($this->rules as $column => $rule) {
            if (!isset($data[$column]) || !$data[$column] instanceof Decimal) {
                continue;
            }

            $data[$column] = $data[$column]->toString();
        }

        return $data;
    }
}
