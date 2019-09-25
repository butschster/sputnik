<?php

namespace App\Contracts\Server;

use App\Contracts\Server\Modules\Configuration;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;

interface Module extends Arrayable
{
    /**
     * Get module categories
     *
     * @return array
     */
    public function categories(): array;

    /**
     * Get module title
     * @return string
     */
    public function title(): string;

    /**
     * Get module key
     * @return string
     */
    public function key(): string;

    /**
     * Get validation rules for module
     *
     * @param Request $request
     *
     * @return array
     */
    public function validationRules(Request $request): array;

    /**
     * Get module configuration
     * @return Configuration
     */
    public function configuration(): Configuration;

    /**
     * Get module dependencies
     * @return array
     */
    public function dependencies(): array;

    /**
     * Get module dictionaries
     * @return array
     */
    public function dictionaries(): array;

    /**
     * Get module default settings
     *
     * @return array
     */
    public function defaultSettings(): array;
}
