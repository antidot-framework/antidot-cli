<?php

declare(strict_types=1);

namespace AntidotTest\Cli\Container\Config;

use Antidot\Cli\Container\Config\ConfigProvider;
use PHPUnit\Framework\TestCase;

class ConfigProviderTest extends TestCase
{
    public function testItShouldHaveMinimumConfigDefined(): void
    {
        $configProvider = new ConfigProvider();
        $this->assertEquals(ConfigProvider::CONFIG, $configProvider());
    }
}
