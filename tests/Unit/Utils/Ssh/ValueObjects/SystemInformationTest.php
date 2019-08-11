<?php

namespace Tests\Unit\Utils\Ssh\ValueObjects;

use App\Utils\SSH\ValueObjects\SystemInformation;
use Tests\TestCase;

class SystemInformationTest extends TestCase
{
    function test_get_os()
    {
        $info = new SystemInformation('Ubuntu', '18.04', '64');

        $this->assertEquals('Ubuntu', $info->getOs());
    }

    function test_get_version()
    {
        $info = new SystemInformation('Ubuntu', '18.04', '64');

        $this->assertEquals('18.04', $info->getVersion());
    }

    function test_get_architecture()
    {
        $info = new SystemInformation('Ubuntu', '18.04', '64');

        $this->assertEquals('64', $info->getArchitecture());
    }

    function test_get_full_name()
    {
        $info = new SystemInformation('Ubuntu', '18.04', '64');

        $this->assertEquals('Ubuntu 18.04 [64 bits]', $info->getFullName());
    }

    function test_os_is_supported()
    {
        config()->set('configurations.os', ['ubuntu' => ['18.04', '19.04']]);

        $info = new SystemInformation('Ubuntu', '18.04', '64');
        $this->assertTrue($info->isSupported());

        $info = new SystemInformation('Ubuntu', '19.04', '64');
        $this->assertTrue($info->isSupported());
    }

    function test_os_is_not_supported()
    {
        config()->set('configurations.os', ['ubuntu' => ['18.04']]);
        $info = new SystemInformation('Ubuntu', '19.04', '64');
        $this->assertFalse($info->isSupported());

        $info = new SystemInformation('Ubuntu', '18.10', '64');
        $this->assertFalse($info->isSupported());
    }
}
