<?php

declare(strict_types=1);

namespace AntidotTest\Cli\Application;

use Antidot\Cli\Application\Console;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArgvInput;

class ConsoleTest extends TestCase
{
    public function testItShouldHaveNameAndVersion(): void
    {
        $console = new Console();
        $this->assertInstanceOf(ArgvInput::class, $console->getInput());
        $this->assertSame(Console::NAME, $console->getName());
        $this->assertSame(Console::VERSION, $console->getVersion());
    }
}
