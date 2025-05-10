<?php

namespace App\Domain\Enum;

use InvalidArgumentException;

enum OrderStatusEnum: string
{
    case OPEN = 'OPEN';

    public static function get(string $status): self
    {
        return match ($status) {
            'OPEN' => self::OPEN,
            default => throw new InvalidArgumentException('Invalid side'),
        };
    }
}
