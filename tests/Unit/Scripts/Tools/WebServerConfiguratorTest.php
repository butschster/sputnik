<?php

namespace Tests\Unit\Scripts\Tools;

use App\Exceptions\Scrpits\ConfigurationNotFoundException;
use App\Contracts\Server\ServerConfiguration;
use App\Scripts\Tools\WebServerConfigurator;
use App\Utils\SSH\ValueObjects\PublicKey;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class WebServerConfiguratorTest extends TestCase
{
    use DatabaseMigrations;

    function test_if_webserer_type_not_found_configurator_should_not_be_created()
    {
        $this->expectException(ConfigurationNotFoundException::class);

        $this->getWebServerConfigurator('unknown');
    }

    function test_gets_type()
    {
        $configurator = $this->getWebServerConfigurator('nginx');
        $this->assertEquals('nginx', $configurator->type());

        $configurator = $this->getWebServerConfigurator('apache');
        $this->assertEquals('apache', $configurator->type());
    }

    function test_gets_available_types()
    {
        $configurator = $this->getWebServerConfigurator();

        $this->assertEquals(['nginx', 'caddy', 'apache'], $configurator->availableTypes());
    }

    /**
     * @dataProvider webserverInstallScriptPartsDataProvider
     */
    function test_gets_install_script($type, array $parts)
    {
        $configurator = $this->getWebServerConfigurator($type);

        $script = $configurator->install();

        foreach ($parts['install'] as $part) {
            $this->assertStringContainsString($part, $script);
        }
    }

    /**
     * @dataProvider webserverInstallScriptPartsDataProvider
     */
    function test_gets_uninstall_script($type, array $parts)
    {
        $configurator = $this->getWebServerConfigurator($type);

        $script = $configurator->uninstall();

        $this->assertStringContainsString($parts['uninstall'], $script);
    }

    /**
     * @dataProvider webserverInstallScriptPartsDataProvider
     */
    function test_gets_restart_script($type, array $parts)
    {
        $configurator = $this->getWebServerConfigurator($type);

        $script = $configurator->restart();

        $this->assertStringContainsString($parts['restart'], $script);
    }

    /**
     * @dataProvider webserverInstallScriptPartsDataProvider
     */
    function test_gets_created_a_new_site_script($type, array $parts)
    {
        $configurator = $this->getWebServerConfigurator($type);

        $site = $this->createServerSite([
            'domain' => 'localhost'
        ]);

        $script = $configurator->createSite($site);
        $this->assertStringContainsString($parts['create_site'], $script);
    }

    /**
     * @dataProvider webserverInstallScriptPartsDataProvider
     */
    function test_gets_deleted_site_script($type, array $parts)
    {
        $configurator = $this->getWebServerConfigurator($type);

        $site = $this->createServerSite([
            'domain' => 'localhost'
        ]);

        $script = $configurator->deleteSite($site);
        $this->assertStringContainsString($parts['delete_site'], $script);
    }


    /**
     * @param string $type
     * @return WebServerConfigurator
     * @throws \App\Exceptions\Scrpits\ConfigurationNotFoundException
     */
    protected function getWebServerConfigurator(string $type = 'nginx'): WebServerConfigurator
    {
        config()->set('configurations.php', ['11']);
        config()->set('configurations.webserver', ['nginx', 'caddy', 'apache']);

        return new WebServerConfigurator(
            new WebServerConfigurationTest($type)
        );
    }

    function webserverInstallScriptPartsDataProvider()
    {
        return [
            [
                'nginx',
                [
                    'delete_site' => 'rm "/etc/nginx/sites-enabled/localhost"',
                    'create_site' => 'cat > /etc/nginx/sites-available/localhost << EOF',
                    'restart' => 'systemctl reload nginx.service',
                    'uninstall' => 'apt-get purge --auto-remove -y --force-yes nginx*',
                    'install' => [
                        'apt-get install -y --force-yes nginx',
                        'systemctl restart php1.1-fpm > /dev/null 2>&1'
                    ]
                ]
            ],
        ];
    }
}

class WebServerConfigurationTest implements ServerConfiguration
{
    /**
     * @var string
     */
    protected $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function phpVersion(): ?string
    {
        return '11';
    }

    public function databaseType(): ?string{}

    public function databasePassword(): ?string {}

    public function databaseHosts(): array {}

    public function webServerType(): ?string
    {
        return $this->type;
    }

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
