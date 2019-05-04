<?php

declare(strict_types=1);

namespace Antidot\Cli\Container\Config;

use Antidot\Cli\Application\Console;
use Antidot\Cli\Container\ConsoleFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'console' => [
                'helper-sets' => [],
                'dependencies' => [
                    'factories' => [
                        Console::class => ConsoleFactory::class,
                    ],
                ],
            ],
        ];
    }
}
