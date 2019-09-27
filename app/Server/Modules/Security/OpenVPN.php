<?php

namespace App\Server\Modules\Security;

use App\Contracts\Server\Modules\Configuration;
use App\Meta\Fields\Number;
use App\Meta\Fields\Select;
use App\Models\Server;
use App\Server\Module;
use Illuminate\Validation\Rule;

class OpenVPN extends Module
{
    /**
     * Get module title
     * @return string
     */
    public function title(): string
    {
        return 'OpenVPN';
    }

    /**
     * Get module key
     * @return string
     */
    public function key(): string
    {
        return 'openvpn';
    }

    /**
     * @return array
     */
    public function defaultSettings(): array
    {
        return [
            'port' => 1194,
            'protocol' => 'udp',
            'dns' => 'opendns'
        ];
    }

    /**
     * @return array
     */
    public function availableDNS(): array
    {
        return [
            'current' => 'Current system resolvers',
            'google' => 'Google',
            'opendns' => 'OpenDNS',
            'verisign' => 'Verisign'
        ];
    }

    /**
     * @return array
     */
    protected function fields(): array
    {
        return [
            (new Number('port', 'VPN port'))
                ->addValidationRule('required')
                ->addValidationRule('digits_between:2,5'),

            (new Select('protocol', 'VPN protocol', ['udp', 'tcp']))
                ->addValidationRule((string) Rule::in(['udp', 'tcp'])),

            (new Select('dns', 'DNS', $this->availableDNS()))
                ->addValidationRule('nullable')
                ->addValidationRule((string) Rule::in(array_keys($this->availableDNS()))),
        ];
    }

    /**
     * Get module configuration
     * @return Configuration
     */
    public function configuration(): Configuration
    {
        return new class($this) extends \App\Server\Modules\Configuration
        {

            /**
             * Install module
             *
             * @param Server $server
             * @param array $data
             * @return array
             */
            public function install(Server $server, array $data): array
            {
                $data['vars'] = $this->vars();
                $data['dns'] = $this->getDNS($data['dns']);

                $script = $this->render($server, 'security.openvpn.install', $data);

                $this->installModule(
                    $server,
                    $script,
                    sprintf('Install %s', $this->module->title())
                );

                return $data;
            }

            /**
             * Uninstall module
             *
             * @param Server $server
             */
            public function uninstall(Server $server): void
            {
                $script = $this->render($server, 'security.openvpn.uninstall');

                $this->runScript(
                    $server,
                    $script,
                    sprintf('Uninstall %s', $this->module->title())
                );
            }

            /**
             * Get openVPN dns servers
             *
             * @param string $type
             * @return array
             */
            public function getDNS(string $type): array
            {
                switch ($type) {
                    case 'google':
                        return [
                            '8.8.8.8',
                            '8.8.4.4'
                        ];
                    case 'opendns':
                        return [
                            '208.67.222.222',
                            '208.67.220.220'
                        ];
                    case 'verisign':
                        return [
                            '64.6.64.6',
                            '64.6.65.6'
                        ];
                }

                return [];
            }

            /**
             * Get the EasyRSA Variables
             *
             * @return array
             */
            public function vars(): array
            {
                return [
                    'EASYRSA_REQ_COUNTRY' => 'US',
                    'EASYRSA_REQ_PROVINCE' => 'NewYork',
                    'EASYRSA_REQ_CITY' => 'New York City',
                    'EASYRSA_REQ_ORG' => 'DigitalOcean',
                    'EASYRSA_REQ_EMAIL' => 'admin@example.com',
                    'EASYRSA_REQ_OU' => 'Community'
                ];
            }
        };
    }
}