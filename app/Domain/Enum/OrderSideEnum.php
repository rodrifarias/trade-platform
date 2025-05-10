<?php

namespace App\Domain\Enum;

use InvalidArgumentException;

enum OrderSideEnum: string
{
    case BUY = 'BUY';
    case SELL = 'SELL';

    public static function get(string $side): self
    {
        return match ($side) {
            'BUY' => self::BUY,
            'SELL' => self::SELL,
            default => throw new InvalidArgumentException('Invalid side'),
        };
    }
}
