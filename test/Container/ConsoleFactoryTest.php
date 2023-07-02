<?php

declare(strict_types=1);

namespace AntidotTest\Cli\Container;

use Antidot\Cli\Application\Console;
use Antidot\Cli\Container\ConsoleFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperInterface;
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
        $this->whenConsoleFactoryIsInvoked();
        $this->thenItShouldHaveAnInstanceOfConsole();
    }

    private function givenDependencyInjectionContainer(): void
    {
        $helper = $this->createMock(HelperSet::class);
        $helper->method('get')->willReturn($this->createMock(HelperInterface::class));
        $command = $this->createMock(Command::class);
        $command->method('getName')->willReturn('some:command');
        $this->container = $this->createMock(ContainerInterface::class);
        $this->container->expects($this->exactly(3))
            ->method('get')
            ->withConsecutive(['config'], [HelperSet::class], [Command::class])
            ->willReturnOnConsecutiveCalls(
                [
                    'console' => [
                        'commands' => [
                            'some:command' => Command::class,
                        ],
                        'helper-sets' => [
                            HelperSet::class,
                        ]
                    ],
                ],
                $helper,
                $command
            );
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
}
