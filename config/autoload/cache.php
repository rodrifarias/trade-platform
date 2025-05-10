<?php

declare(strict_types=1);

use function Hyperf\Support\env;

return [
    'default' => [
        'driver' => Hyperf\Cache\Driver\FileSystemDriver::class,
        'packer' => Hyperf\Codec\Packer\PhpSerializerPacker::class,
        'prefix' => env('APP_NAME') . ':',
    ],
];
