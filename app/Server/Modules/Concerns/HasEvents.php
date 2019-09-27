<?php

namespace App\Server\Modules\Concerns;

use App\Models\Server;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Arr;
use InvalidArgumentException;

trait HasEvents
{
    /**
     * The event map for the model.
     *
     * Allows for object-based events for native Eloquent events.
     *
     * @var array
     */
    protected $dispatchesEvents = [];

    /**
     * User exposed observable events.
     *
     * These are extra user-defined events observers may subscribe to.
     *
     * @var array
     */
    protected $observables = [];

    /**
     * Register observers with the model.
     *
     * @param object|array|string $classes
     * @return void
     *
     * @throws \RuntimeException
     */
    public static function observe($classes): void
    {
        $instance = new static;

        foreach (Arr::wrap($classes) as $class) {
            $instance->registerObserver($class);
        }
    }

    /**
     * Register a single observer with the model.
     *
     * @param object|string $class
     * @return void
     *
     * @throws \RuntimeException
     */
    protected function registerObserver($class): void
    {
        $className = $this->resolveObserverClassName($class);

        // When registering a model observer, we will spin through the possible events
        // and determine if this observer has that method. If it does, we will hook
        // it into the model's event system, making it convenient to watch these.
        foreach ($this->getObservableEvents() as $event) {
            if (method_exists($class, $event)) {
                static::registerEvent($event, $className . '@' . $event);
            }
        }
    }

    /**
     * Resolve the observer's class name from an object or string.
     *
     * @param object|string $class
     * @return string
     *
     * @throws InvalidArgumentException
     */
    private function resolveObserverClassName($class): string
    {
        if (is_object($class)) {
            return get_class($class);
        }

        if (class_exists($class)) {
            return $class;
        }

        throw new InvalidArgumentException('Unable to find observer: ' . $class);
    }

    /**
     * Get the observable event names.
     *
     * @return array
     */
    public function getObservableEvents(): array
    {
        return array_merge(
            [
                'installing', 'installed', 'uninstalling', 'uninstalled', 'restarting',
                'restarted', 'stopping', 'stopped', 'starting', 'started',
            ],
            $this->observables
        );
    }

    /**
     * Set the observable event names.
     *
     * @param array $observables
     */
    public function setObservableEvents(array $observables): void
    {
        $this->observables = $observables;
    }

    /**
     * Add an observable event name.
     *
     * @param array|mixed $observables
     * @return void
     */
    public function addObservableEvents(array $observables): void
    {
        $this->observables = array_unique(array_merge(
            $this->observables, $observables
        ));
    }

    /**
     * Register a model event with the dispatcher.
     *
     * @param string $event
     * @param \Closure|string $callback
     * @return void
     */
    protected static function registerEvent($event, $callback)
    {
        if (isset(static::$dispatcher)) {
            $name = static::class;

            static::$dispatcher->listen("server.module.{$event}: {$name}", $callback);
        }
    }

    /**
     * Fire the given event for the module.
     *
     * @param string $event
     * @param Server $server
     * @param bool $halt
     * @return mixed
     */
    public function fireEvent($event, Server $server, $halt = true)
    {
        if (!isset(static::$dispatcher)) {
            return true;
        }

        // First, we will get the proper method to call on the event dispatcher, and then we
        // will attempt to fire a custom, object based event for the given event. If that
        // returns a result we can return that result, or we'll call the string events.
        $method = $halt ? 'until' : 'dispatch';

        $result = $this->filterEventResults(
            $this->fireCustomEvent($event, $method)
        );

        if ($result === false) {
            return false;
        }

        return !empty($result) ? $result : static::$dispatcher->{$method}(
            "server.module.{$event}: " . static::class, $server
        );
    }

    /**
     * Fire a custom event for the given event.
     *
     * @param string $event
     * @param string $method
     * @return mixed|null
     */
    protected function fireCustomEvent($event, $method)
    {
        if (!isset($this->dispatchesEvents[$event])) {
            return;
        }

        $result = static::$dispatcher->$method(new $this->dispatchesEvents[$event]($this));

        if (!is_null($result)) {
            return $result;
        }
    }

    /**
     * Filter the event results.
     *
     * @param mixed $result
     * @return mixed
     */
    protected function filterEventResults($result)
    {
        if (is_array($result)) {
            $result = array_filter($result, function ($response) {
                return !is_null($response);
            });
        }

        return $result;
    }

    /**
     * @param \Closure|string $callback
     * @return void
     */
    public static function installing($callback): void
    {
        static::registerEvent('installing', $callback);
    }

    /**
     * @param \Closure|string $callback
     * @return void
     */
    public static function installed($callback): void
    {
        static::registerEvent('installed', $callback);
    }

    /**
     * @param \Closure|string $callback
     * @return void
     */
    public static function uninstalling($callback): void
    {
        static::registerEvent('uninstalling', $callback);
    }

    /**
     * @param \Closure|string $callback
     * @return void
     */
    public static function uninstalled($callback): void
    {
        static::registerEvent('uninstalled', $callback);
    }

    /**
     * @param \Closure|string $callback
     * @return void
     */
    public static function restarting($callback): void
    {
        static::registerEvent('restarting', $callback);
    }

    /**
     * @param \Closure|string $callback
     * @return void
     */
    public static function restarted($callback): void
    {
        static::registerEvent('restarted', $callback);
    }

    /**
     * @param \Closure|string $callback
     * @return void
     */
    public static function starting($callback): void
    {
        static::registerEvent('starting', $callback);
    }

    /**
     * @param \Closure|string $callback
     * @return void
     */
    public static function started($callback): void
    {
        static::registerEvent('started', $callback);
    }

    /**
     * @param \Closure|string $callback
     * @return void
     */
    public static function stopping($callback): void
    {
        static::registerEvent('starting', $callback);
    }

    /**
     * @param \Closure|string $callback
     * @return void
     */
    public static function stopped($callback): void
    {
        static::registerEvent('started', $callback);
    }

    /**
     * Get the event dispatcher instance.
     *
     * @return \Illuminate\Contracts\Events\Dispatcher
     */
    public static function getEventDispatcher()
    {
        return static::$dispatcher;
    }

    /**
     * Set the event dispatcher instance.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $dispatcher
     * @return void
     */
    public static function setEventDispatcher(Dispatcher $dispatcher)
    {
        static::$dispatcher = $dispatcher;
    }

    /**
     * Unset the event dispatcher for models.
     *
     * @return void
     */
    public static function unsetEventDispatcher()
    {
        static::$dispatcher = null;
    }
}