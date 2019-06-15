<?php

declare(strict_types=1);

namespace AntidotTest\Cli\Container;

use Antidot\Cli\Application\Console;
use Antidot\Cli\Container\ConsoleFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperSet;

class ConsoleFactoryTest extends TestCase
{
    /** @var MockObject|ContainerInterface */
    private $container;
    /** @var Console */
    private $console;

    public function testItShouldCreateNewConsoleInstances(): void
    {
        $this->givenDependencyInjectionContainer();
        $this->havingConsoleConfig();
        $this->havingAConsoleCommand();
        $this->havingAConsoleHelperSet();
        $this->whenConsoleFactoryIsInvoked();
        $this->thenItShouldHaveAnInstanceOfConsole();
    }

    private function givenDependencyInjectionContainer(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
    }

    private function havingConsoleConfig(): void
    {
        $this->container
            ->expects($this->at(0))
            ->method('get')
            ->with('config')
            ->willReturn([
                'console' => [
                    'commands' => [
                        'some:command' => Command::class,
                    ],
                    'helper-sets' => [
                        HelperSet::class,
                    ]
                ],
            ]);
    }

    private function whenConsoleFactoryIsInvoked(): void
    {
        $factory = new ConsoleFactory();
        $this->console = $factory->__invoke($this->container);
    }

    private function thenItShouldHaveAnInstanceOfConsole(): void
    {
        $this->console->all();
        $this->assertInstanceOf(Console::class, $this->console);
    }

    private function havingAConsoleCommand(): void
    {
        $command = $this->createMock(Command::class);
        $command->method('getName')->willReturn('some:command');

        $this->container
            ->expects($this->at(2))
            ->method('get')
            ->with(Command::class)
            ->willReturn($command);
    }

    private function havingAConsoleHelperSet(): void
    {
        $helper = $this->createMock(HelperSet::class);
        $helper->method('get')->willReturn('question');

        $this->container
            ->expects($this->at(1))
            ->method('get')
            ->with(HelperSet::class)
            ->willReturn($helper);
    }
}
