<?php

namespace Module\OpenVPN;

use App\Contracts\Server\Module;
use App\Contracts\Server\Modules\Action\Extension;
use App\Contracts\Server\Modules\Action\HasFields;
use App\Contracts\Server\Modules\Action\HasSettings;
use App\Meta\Fields\Number;
use App\Meta\Fields\Select;
use App\Models\Server;
use Illuminate\Validation\Rule;

class OpenVPNSettings implements Extension, HasSettings, HasFields
{
    /**
     * Check if action can be run
     *
     * @param Module $module
     * @param Server $server
     * @param array $data
     * @return bool
     */
    public function isValid(Module $module, Server $server, array $data = []): bool
    {
        return true;
    }

    /**
     * @param Module $module
     * @param Server $server
     * @param array $data
     * @return array
     */
    public function data(Module $module, Server $server, array $data = []): array
    {
        return [
            'vars' => $this->vars(),
            'dns' => $this->getDNS($data['dns'])
        ];
    }

    /**
     * @return array
     */
    public function settings(): array
    {
        return [
            'port' => 1194,
            'protocol' => 'udp',
            'dns' => 'opendns',
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
    public function fields(): array
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
}