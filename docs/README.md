# Antidot Framework Console Tool

This library is an adapter for using the [Symfony Console component](https://symfony.com/doc/current/components/console.html) 
using the standard Zend Framework configuration and any dependency injection container compatible with 
the `Psr\ContainerInterface`

## Install

Using composer package manager

````bash
composer require antidot-fw/cli
````

### Antidot Framework:

The Cli component is installed by default in [Antidot Framework Starter](https://github.com/antidot-framework/antidot-starter)

### Zend Expressive:

The Cli component will be automatically installed by running composer require command when we have previously 
installed the library [Zend Config Aggregator](https://github.com/zendframework/zend-config-aggregator)

All we'll need to do is create the Console entry point:

````php
#!/usr/bin/env php
<?php
// bin/console

declare(strict_types=1);

use Antidot\Cli\Application\Console;

set_time_limit(0);

call_user_func(static function (): void {
    require __DIR__.'/../vendor/autoload.php';
    $container = require __DIR__.'/../config/container.php';
    $console = $container->get(Console::class);

    $console->run();
});
````

Finally we will give execution permissions to the file `bin/console`

````bash
# Debian systems
chmod +x bin/console
````

### As Standalone application

The Cli component can also be used to create console applications without any Framework, 
all we need is an implementation of the dependency injection container compatible with the 
standard `Psr\ContainerInterface`

Assuming we create a project with the following structure:

````
bin/console
config/container.php
composer.json
````

As a dependency we could use the [Antidot Framework adapter For Aura Container](https://github.com/antidot-framework/aura-container-config)

````json
# composer.json
{
    "name": "antidot-fw/console-example",
    "description": "Antidot framework console project example",
    "type": "project",
    "require": {
        "antidot-fw/cli": "dev-master",
        "antidot-fw/aura-container-config": "dev-master"
    },
    "require-dev": {
        "symfony/var-dumper": "^4.3"
    },
    "autoload": {
        "psr-4": {
            "App\\": "src"
        }
    }
}
````

We create the file `config/container.php` that must return a configured instance of `Psr\ContainerInterface` to us.

````php
<?php
// config/container.php
use Aura\Di\ContainerBuilder;
use Antidot\Aura\Container\Config\ContainerConfig;

// Load configuration
$config = [ 'dependencies' => [], 'console' => [ 'commands' => [] ] ];
// Build container
$builder = new ContainerBuilder();
return $builder->newConfiguredInstance([
    new ContainerConfig(\is_array($config) ? $config : []),
], $builder::AUTO_RESOLVE);
````

We need to create the Console entry point:

````php
<?php
// bin/console

declare(strict_types=1);

use Antidot\Cli\Application\Console;

set_time_limit(0);

call_user_func(static function (): void {
    require __DIR__.'/../vendor/autoload.php';
    $container = require __DIR__.'/../config/container.php';
    $console = $container->get(Console::class);

    $console->run();
});
````

And give to it execution permissions

````bash
# Debian systems
chmod +x bin/console
````

## Usage

Una vez instalada la Consola, podemos ver los comndos disponibles ejecutando el punto de entrada con el parametro 
`list` o sin parametro

````bash
bin/console
````

### Create Commands

To create console commands you need to create a class that extends from `Symfony\Component\Console\Command\Command` 

````php
<?php
// src/Console/SomeCommand

declare(strict_types=1);

namespace App\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use SomeDependency;

class SomeCommand extends Command
{
    /**
     * You can inject dependencies by constructor 
     * @var SomeDependency 
     */
    private $dependency;
    
    public function __construct(SomeDependency $dependency) {
        $this->dependency = $dependency;
        parent::__construct();
    }
    
    protected function configure(): void
    {
        $this->setName('some:command:name');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeLn('Hello World!!!');        
    }
}
````

For more information you can see [the official documentation](https://symfony.com/doc/current/console.html) of Symfony in this regard.

### Config

The configuration consists of three different elements: `dependencies`, `console.commands` y `console.helper-sets`

````php
<?php
$config =  [
   'config_cache_path' => 'var/cache/config-cache.php',
   'dependencies' => [
       'invokables' => [
            SomeCommandClass::class => SomeCommandClass::class,
            SomeHelperSet::class => SomeHelperSet::class,
        ]
   ],
   'console' => [
       'commands' => [
           'some:command:name' => SomeCommandClass::class
       ],
       'helper-sets' => [
            SomeHelperSet::class
        ]
   ]
];
````
