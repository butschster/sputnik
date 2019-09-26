<?php

namespace App\Server;

use App\Meta\FieldsCollection;

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
            'fields' => $this->getFields(),
            'defaults' => $this->defaultSettings(),
        ];
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
     * @return array
     */
    public function defaultSettings(): array
    {
        return [];
    }

    /**
     * @return FieldsCollection
     */
    public function getFields(): FieldsCollection
    {
        return new FieldsCollection($this->fields());
    }

    /**
     * @return array
     */
    protected function fields(): array
    {
        return [];
    }
}
