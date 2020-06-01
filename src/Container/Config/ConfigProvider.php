<?php

declare(strict_types=1);

namespace Antidot\Cli\Container\Config;

use Antidot\Cli\Application\Console;
use Antidot\Cli\Container\ConsoleFactory;

class ConfigProvider
{
    public const CONFIG = [
        'console' => [
            'helper-sets' => [],
            'commands' => [],
        ],
        'factories' => [
            Console::class => ConsoleFactory::class,
        ],
    ];

    public function __invoke(): array
    {
        return self::CONFIG;
    }
}
