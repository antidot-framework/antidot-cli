<?php

declare(strict_types=1);

namespace Antidot\Cli\Container;

use Antidot\Cli\Application\Console;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;

use function array_walk;

class ConsoleFactory
{
    public function __invoke(ContainerInterface $container): Console
    {
        $config = $container->get('config')['console'];
        /** @var Console $console */
        $console = new Console();
        $commands = $config['commands'] ?? [];
        $lazyCommands = [];
        foreach ($commands as $name => $command) {
            $lazyCommands[$name] = static function () use ($command, $container): Command {
                return $container->get($command);
            };
        }
        $console->setCommandLoader(new FactoryCommandLoader($lazyCommands));
        array_walk(
            $config['helper-sets'],
            static function (string $helperSet) use ($console, $container): void {
                $console->setHelperSet($container->get($helperSet));
            }
        );

        return $console;
    }
}
