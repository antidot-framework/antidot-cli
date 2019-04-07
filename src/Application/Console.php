<?php

declare(strict_types=1);

namespace Antidot\Cli\Application;

use Symfony\Component\Console\Application;

final class Console extends Application
{
    public function __construct(string $name = 'AntiDot Framework Console Tool', string $version = '1.0.0')
    {
        parent::__construct($name, $version);
    }
}
