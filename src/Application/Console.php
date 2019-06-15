<?php

declare(strict_types=1);

namespace Antidot\Cli\Application;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Console extends Application
{
    public const NAME = 'AntiDot Framework Console Tool';
    public const VERSION = '1.0.0';

    /** @var InputInterface */
    private $input;

    public function __construct(string $name = self::NAME, string $version = self::VERSION)
    {
        $this->input = new ArgvInput();
        parent::__construct($name, $version);
    }

    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        return parent::run($input ?? $this->input, $output);
    }

    public function getInput(): InputInterface
    {
        return $this->input;
    }
}
