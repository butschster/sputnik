<?php

namespace App\Server\Modules\PHP;

use App\Server\Module as BaseModule;
use App\Contracts\Server\Modules\Configuration;
use Illuminate\Http\Request;

abstract class Module extends BaseModule
{
    /**
     * @return string
     */
    abstract public function version(): string;

    /**
     * Get module title
     * @return string
     */
    public function title(): string
    {
        return 'PHP ' . $this->humanReadableVersion();
    }

    /**
     * Get current version of PHP
     * @return string
     */
    public function humanReadableVersion(): string
    {
        return implode('.', str_split($this->version()));
    }

    /**
     * Get module key
     * @return string
     */
    public function key(): string
    {
        return 'php' . $this->version();
    }

    /**
     * Get validation rules for module
     *
     * @param Request $request
     *
     * @return array
     */
    public function validationRules(Request $request): array
    {
        return [
            'modules' => 'nullable|array'
        ];
    }

    /**
     * Get module configuration
     *
     * @return Configuration
     */
    public function configuration(): Configuration
    {
        return new \App\Server\Modules\PHP\Configuration($this);
    }
 }
