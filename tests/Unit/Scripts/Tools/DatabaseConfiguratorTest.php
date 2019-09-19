<?php

namespace Tests\Unit\Scripts\Tools;

use App\Exceptions\Scrpits\ConfigurationNotFoundException;
use App\Contracts\Server\ServerConfiguration;
use App\Scripts\Tools\DatabaseConfigurator;
use App\Utils\SSH\ValueObjects\PublicKey;
use Tests\TestCase;

class DatabaseConfiguratorTest extends TestCase
{
    function test_if_database_type_not_found_configurator_should_not_be_created()
    {
        $this->expectException(ConfigurationNotFoundException::class);

        $this->getDatabaseConfigurator('unknown');
    }

    function test_gets_available_types()
    {
        $configurator = $this->getDatabaseConfigurator();

        $this->assertEquals(['mysql', 'mysql8', 'mariadb', 'pgsql'], $configurator->availableTypes());
    }

    function test_gets_type()
    {
        $configurator = $this->getDatabaseConfigurator('mysql');
        $this->assertEquals('mysql', $configurator->type());

        $configurator = $this->getDatabaseConfigurator('pgsql');
        $this->assertEquals('pgsql', $configurator->type());
    }

    function test_gets_password()
    {
        $configurator = $this->getDatabaseConfigurator('mysql');
        $this->assertEquals('--password--', $configurator->password());
    }

    /**
     * @dataProvider databaseInstallScriptPartsDataProvider
     */
    function test_gets_install_script($type, array $parts)
    {
        $configurator = $this->getDatabaseConfigurator($type);

        $script = $configurator->install();

        foreach ($parts['install'] as $part) {
            $this->assertStringContainsString($part, $script);
        }
    }

    /**
     * @dataProvider databaseInstallScriptPartsDataProvider
     */
    function test_gets_uninstall_script($type, array $parts)
    {
        $configurator = $this->getDatabaseConfigurator($type);

        $script = $configurator->uninstall();

        $this->assertStringContainsString($parts['uninstall'], $script);
    }

    /**
     * @dataProvider databaseInstallScriptPartsDataProvider
     */
    function test_gets_restart_script($type, array $parts)
    {
        $configurator = $this->getDatabaseConfigurator($type);

        $script = $configurator->restart();

        $this->assertStringContainsString($parts['restart'], $script);
    }

    function test_gets_created_a_new_database_script()
    {
        $this->markTestSkipped('Cover database creating');
    }

    /**
     * @param string $type
     * @param array $hosts
     * @return DatabaseConfigurator
     * @throws \App\Exceptions\Scrpits\ConfigurationNotFoundException
     */
    protected function getDatabaseConfigurator(string $type = 'mysql', array $hosts = ['host-1', 'host-2']): DatabaseConfigurator
    {
        config()->set('configurations.database', ['mysql', 'mysql8', 'mariadb', 'pgsql']);

        return new DatabaseConfigurator(
            new DatabaseConfigurationTest($type, $hosts)
        );
    }

    function databaseInstallScriptPartsDataProvider()
    {
        return [
            [
                'mariadb',
                [
                    'restart' => 'systemctl restart mysql',
                    'uninstall' => 'apt-get purge --auto-remove -y --force-yes mariadb*',
                    'install' => [
                        '# MariaDB',
                        'apt-get install -y mariadb-server-10.3',
                        'mysql --user="root" --password="--password--" -e "FLUSH PRIVILEGES;"'
                    ]
                ]
            ],
            [
                'mysql',
                [
                    'restart' => 'systemctl restart mysql',
                    'uninstall' => 'apt-get purge --auto-remove -y --force-yes mysql*',
                    'install' => [
                        '# MySQL',
                        'apt-get install -y mysql-server',
                        'mysql --user="root" --password="--password--" -e "FLUSH PRIVILEGES;"'
                    ]
                ]
            ],
            [
                'mysql8',
                [
                    'restart' => 'systemctl restart mysql',
                    'uninstall' => 'apt-get purge --auto-remove -y --force-yes mysql*',
                    'install' => [
                        '# MySQL 8',
                        'dpkg --install mysql-apt-config_0.8.12-1_all.deb',
                        'apt-get install -y mysql-server',
                        'mysql --user="root" --password="--password--" -e "FLUSH PRIVILEGES;"'
                    ]
                ]
            ],
            [
                'pgsql',
                [
                    'restart' => 'service postgresql restart',
                    'uninstall' => 'apt-get purge --auto-remove -y --force-yes postgresql*',
                    'install' => [
                        '# PostgreSQL',
                        'apt-get install -y --force-yes postgresql postgresql-contrib',
                        'sed -i "s/#listen_addresses = \'localhost\'/listen_addresses = \'host-1,host-2\'/g" /etc/postgresql/11/main/postgresql.conf',
                        'CREATE ROLE test_user LOGIN PASSWORD \'--password--\''
                    ]
                ]
            ]
        ];
    }
}

class DatabaseConfigurationTest implements ServerConfiguration
{
    /**
     * @var string
     */
    protected $type;
    /**
     * @var array
     */
    protected $hosts;

    public function __construct(string $type, array $hosts)
    {
        $this->type = $type;
        $this->hosts = $hosts;
    }

    public function phpVersion(): ?string
    {
        return '71';
    }

    public function databaseType(): ?string
    {
        return $this->type;
    }

    public function databasePassword(): ?string
    {
        return '--password--';
    }

    public function databaseHosts(): array
    {
        return $this->hosts;
    }

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

