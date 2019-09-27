<?php

namespace App\Server;

use App\Meta\FieldsCollection;
use App\Server\Modules\Concerns\HasEvents;

abstract class Module implements \App\Contracts\Server\Module
{
    use HasEvents;

    /**
     * The event dispatcher instance.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected static $dispatcher;

    /**
     * The array of booted modules.
     *
     * @var array
     */
    protected static $booted = [];

    public function __construct()
    {
        $this->bootIfNotBooted();
    }

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

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {

    }

    /**
     * Check if the model needs to be booted and if so, do it.
     *
     * @return void
     */
    protected function bootIfNotBooted()
    {
        if (! isset(static::$booted[static::class])) {
            static::$booted[static::class] = true;
            static::boot();
        }
    }
}
