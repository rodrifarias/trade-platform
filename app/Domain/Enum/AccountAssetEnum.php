<?php

namespace App\Domain\Enum;

use InvalidArgumentException;

enum AccountAssetEnum: string
{
    case BTC = 'BTC';
    case USD = 'USD';

    public static function get(string $assetId): self
    {
        return match ($assetId) {
          'BTC' => self::BTC,
          'USD' => self::USD,
          default => throw new InvalidArgumentException('Invalid asset id'),
        };
    }
}
