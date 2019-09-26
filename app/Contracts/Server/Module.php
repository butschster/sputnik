<?php

namespace App\Contracts\Server;

use App\Contracts\Server\Modules\Configuration;
use App\Meta\FieldsCollection;
use Illuminate\Contracts\Support\Arrayable;

interface Module extends Arrayable
{
    /**
     * Get module categories
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
     * Get module default settings
     * @return array
     */
    public function defaultSettings(): array;

    /**
     * @return FieldsCollection
     */
    public function getFields(): FieldsCollection;
}
