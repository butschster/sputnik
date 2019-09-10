<?php

namespace App\Http\WebHooks;

use App\Contracts\Http\WebHooks\Manager as ManagerContract;
use App\Contracts\Http\WebHooks\WebHook;
use App\Models\Server\Site;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class Manager implements ManagerContract
{
    /**
     * @var array
     */
    protected $hooks;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     * @param array $hooks
     */
    public function __construct(Application $app, array $hooks)
    {
        $this->hooks = $hooks;
        $this->app = $app;
    }

    /**
     * @param Request $request
     * @param mixed ...$args
     */
    public function call(Request $request, ...$args): void
    {
        collect(array_keys($this->hooks))->map(function ($hook) use ($request) {
            return $this->app->make($hook);
        })->filter(function (WebHook $hook) use ($request) {
            return $hook->isValid($request);
        })->each(function (WebHook $hook) use ($args) {
            $this->fireEvents($hook, ...$args);
        });
    }

    /**
     * @param WebHook $hook
     * @param mixed ...$args
     */
    protected function fireEvents(WebHook $hook, ...$args)
    {
        foreach ($this->getEvents($hook) as $event) {
            event(new $event(...$args));
        }
    }

    /**
     * @param WebHook $hook
     *
     * @return array
     */
    protected function getEvents(WebHook $hook): array
    {
        return (array) Arr::get($this->hooks, get_class($hook));
    }
}
