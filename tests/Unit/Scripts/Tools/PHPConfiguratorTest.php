<?php

namespace Tests\Unit\Scripts\Tools;

use App\Exceptions\Scrpits\ConfigurationNotFoundException;
use App\Contracts\Server\ServerConfiguration;
use App\Scripts\Tools\PHPConfigurator;
use App\Utils\SSH\ValueObjects\PublicKey;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PHPConfiguratorTest extends TestCase
{
    use DatabaseMigrations;

    function test_if_php_version_not_found_configurator_should_not_be_created()
    {
        $this->expectException(ConfigurationNotFoundException::class);

        $this->getPHPConfigurator('51');
    }

    function test_gets_php_version()
    {
        $configurator = $this->getPHPConfigurator();

        $this->assertEquals('71', $configurator->version());
        $this->assertEquals('7.1', $configurator->humanReadableVersion());
    }

    function test_gets_available_versions()
    {
        $configurator = $this->getPHPConfigurator();

        $this->assertEquals(
            ['71', '72', '74'], $configurator->availableVersions()
        );
    }

    /**
     * @dataProvider phpInstallScriptPartsDataProvider
     * @throws \App\Exceptions\Scrpits\ConfigurationNotFoundException
     * @throws \Throwable
     */
    function test_gets_install_script($version, array $parts)
    {
        $configurator = $this->getPHPConfigurator($version);

        $script = $configurator->install();
        $this->assertStringContainsString('callback-----url', $script);

        foreach ($parts['install'] as $part) {
            $this->assertStringContainsString($part, $script);
        }
    }

    /**
     * @dataProvider phpInstallScriptPartsDataProvider
     * @throws \App\Exceptions\Scrpits\ConfigurationNotFoundException
     * @throws \Throwable
     */
    function test_gets_uninstall_script($version, array $parts)
    {
        $configurator = $this->getPHPConfigurator($version);

        $script = $configurator->uninstall();
        $this->assertStringContainsString($parts['uninstall'], $script);
    }

    /**
     * @dataProvider phpInstallScriptPartsDataProvider
     * @throws \App\Exceptions\Scrpits\ConfigurationNotFoundException
     * @throws \Throwable
     */
    function test_gets_restart_script($version, array $parts)
    {
        $configurator = $this->getPHPConfigurator($version);

        $script = $configurator->restart();
        $this->assertStringContainsString($parts['restart'], $script);
    }
    /**
     * @dataProvider phpInstallScriptPartsDataProvider
     */
    function test_install_modules($version, array $parts)
    {
        $configurator = $this->getPHPConfigurator($version);

        $script = $configurator->installModules('test-module', 'bcmath');
        $this->assertStringContainsString($parts['modules'], $script);
    }

    /**
     * @return PHPConfigurator
     * @throws \App\Exceptions\Scrpits\ConfigurationNotFoundException
     */
    protected function getPHPConfigurator(string $version = '71'): PHPConfigurator
    {
        config()->set('configurations.php', ['71', '72', '74']);

        return new PHPConfigurator(
            new PHPConfigurationTest($version)
        );
    }

    function phpInstallScriptPartsDataProvider()
    {
        return [
            [
                '71',
                [
                    'modules' => 'apt-get install -y --force-yes php7.1-test-module php7.1-bcmath',
                    'restart' => 'systemctl restart php7.1-fpm > /dev/null 2>&1',
                    'uninstall' => 'apt-get purge -y --force-yes --auto-remove php7.1-common',
                    'install' => [
                        '# PHP 7.1',
                        'echo "test_user ALL=NOPASSWD: /usr/sbin/service php7.1-fpm reload" > /etc/sudoers.d/php-fpm'
                    ]
                ]
            ],
            [
                '72',
                [
                    'modules' => 'apt-get install -y --force-yes php7.2-test-module',
                    'restart' => 'systemctl restart php7.2-fpm > /dev/null 2>&1',
                    'uninstall' => 'apt-get purge -y --force-yes --auto-remove php7.2-common',
                    'install' => [
                        '# PHP 7.2',
                        'echo "test_user ALL=NOPASSWD: /usr/sbin/service php7.2-fpm reload" > /etc/sudoers.d/php-fpm'
                    ]
                ]
            ],
            [
                '74',
                [
                    'modules' => 'apt-get install -y --force-yes php7.4-test-module',
                    'restart' => 'systemctl restart php7.4-fpm > /dev/null 2>&1',
                    'uninstall' => 'apt-get purge -y --force-yes --auto-remove php7.4-common',
                    'install' => [
                        '# PHP 7.4',
                        'echo "test_user ALL=NOPASSWD: /usr/sbin/service php7.4-fpm reload" > /etc/sudoers.d/php-fpm'
                    ]
                ]
            ]
        ];
    }
}

class PHPConfigurationTest implements ServerConfiguration
{
    /**
     * @var string
     */
    protected $version;

    public function __construct(string $version)
    {
        $this->version = $version;
    }

    public function phpVersion(): ?string
    {
        return $this->version;
    }

    public function databaseType(): ?string{}

    public function databasePassword(): ?string {}

    public function databaseHosts(): array {}

    public function webServerType(): ?string{}

    public function noSqlDatabases(): array{}

    public function systemUsers(): array
    {
        return ['test_user'];
    }

    public function publicKey(): PublicKey {}

    public function callbackUrl(string $message): string
    {
        return 'callback-----url';
    }
}
