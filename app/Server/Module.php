<?php

namespace App\Server;

use Illuminate\Http\Request;

abstract class Module implements \App\Contracts\Server\Module
{
    /**
     * Get module categories
     * @return array
     */
    public function categories(): array
    {
        return [];
    }

    /**
     * Get the instance as an array.
     * @return array
     */
    public function toArray()
    {
        return [
            'title' => $this->title(),
            'key' => $this->key(),
            'categories' => $this->categories(),
            'dependencies' => $this->dependencies(),
            'dictionaries' => $this->dictionaries(),
        ];
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
        return [];
    }

    /**
     * Get module dependencies
     * @return array
     */
    public function dependencies(): array
    {
        return [];
    }

    /**
     * Get module dictionaries
     * @return array
     */
    public function dictionaries(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function defaultSettings(): array
    {
        return [];
    }
}
