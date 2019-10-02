<?php

namespace App\Server\Modules;

use App\Contracts\Server\Module;
use App\Contracts\Server\Modules\Action as ActionContract;
use App\Events\Server\Module\ActionRan;
use App\Jobs\Task\Run;
use App\Meta\FieldsCollection;
use App\Models\Server;
use App\Scripts\Server\CustomScript;
use App\Server\Modules\Concerns\HasEvents;
use App\Services\Task\Factory;
use Illuminate\Support\Traits\Macroable;

class Action implements ActionContract
{
    /**
     * @var string
     */
    protected $configuratorView = 'scripts.server.modules.configurator';

    /**
     * @var array
     */
    protected $callbacks = [];

    /**
     * @var Module
     */
    protected $module;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $scriptView;

    /**
     * @var ActionContract\Extension[]
     */
    protected $extensions = [];

    /**
     * @param Module $module
     * @param string $key
     * @param string $name
     * @param string $scriptView
     * @param array $callbacks
     */
    public function __construct(Module $module, string $key, string $name, string $scriptView, array $callbacks = [])
    {
        $this->module = $module;
        $this->key = $key;
        $this->name = $name;
        $this->scriptView = $scriptView;

        foreach ($callbacks as $callback) {
            $this->registerCallback($callback);
        }
    }

    /**
     * Get action key
     *
     * @return string
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    protected function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    protected function scriptView(): string
    {
        return $this->scriptView;
    }

    /**
     * @return array
     */
    public function settings(): array
    {
        $settings = [];

        foreach ($this->extensions as $extension) {
            if ($extension instanceof ActionContract\HasSettings) {
                $settings = array_merge($settings, $extension->settings());
            }
        }

        return $settings;
    }

    /**
     * @return array
     */
    protected function fields(): array
    {
        $fields = [];

        foreach ($this->extensions as $extension) {
            if ($extension instanceof ActionContract\HasFields) {
                $fields = array_merge($fields, $extension->fields());
            }
        }

        return $fields;
    }

    /**
     * @param string $callback
     */
    public function registerCallback(string $callback): void
    {
        $this->callbacks[] = $callback;
    }

    /**
     * @param ActionContract\Extension $extension
     */
    public function registerExtension(ActionContract\Extension $extension)
    {
        $this->extensions[] = $extension;
        if ($extension instanceof ActionContract\HasCallbacks) {
            foreach ($extension->callbacks() as $callback) {
                $this->registerCallback($callback);
            }
        }
    }

    /**
     * @param Server $server
     * @param array $data
     * @return bool
     */
    public function isValid(Server $server, array $data = []): bool
    {
        foreach ($this->extensions as $extension) {
            if (!$extension->isValid($this->module, $server, $data)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Run action script
     *
     * @param Server $server
     * @param array $data
     * @param array $callbacks
     * @return Server\Task
     * @throws \Throwable
     */
    public function run(Server $server, array $data = [], array $callbacks = []): Server\Task
    {
        $task = $this->createTaskForScript(
            $server, $data
        );

        foreach (array_merge($callbacks, $this->callbacks) as $callback) {
            $task->addCallback($callback);
        }

        dispatch(new Run($task));

        event(
            new ActionRan($server, $this->module, $this, $data)
        );

        return $task;
    }

    /**
     * @param Server $server
     * @param array $data
     *
     * @return array
     */
    protected function prepareData(Server $server, array $data): array
    {
        $extensionsData = [];

        foreach ($this->extensions as $extension) {
            $extensionsData = array_merge(
                $extensionsData,
                $extension->data($this->module, $server, $data)
            );
        }

        return array_merge(
            $this->settings(),
            $extensionsData,
            $data
        );
    }

    /**
     * @param Server $server
     * @param array $data
     * @return \App\Services\Task\Contracts\Task
     * @throws \Throwable
     */
    protected function createTaskForScript(Server $server, array $data): \App\Services\Task\Contracts\Task
    {
        $script = $this->render($server, $data);

        return (new Factory())->createFromScript(
            $server,
            new CustomScript($this->buildName(), $script),
            ['module' => $this->module->key()]
        );
    }

    /**
     * Render script view
     *
     * @param Server $server
     * @param array $data
     *
     * @return string
     * @throws \Throwable
     */
    public function render(Server $server, array $data = []): string
    {
        $data = array_merge(
            $this->prepareData($server, $data),
            [
                'module' => $this->module,
                'server' => $server,
                'users' => $server->toConfiguration()->systemUsers(),
            ]
        );

        return view($this->configuratorView, [
            'script' => view($this->buildScriptView(), $data)->render(),
            'callback' => null,
        ])->render();
    }

    /**
     * @return FieldsCollection
     */
    public function getFields(): FieldsCollection
    {
        return new FieldsCollection($this->fields());
    }

    /**
     * @return string
     */
    protected function buildName(): string
    {
        return strtr($this->name(), [
            ':module' => $this->module->title(),
        ]);
    }

    /**
     * @return string
     */
    protected function buildScriptView(): string
    {
        return strtr($this->scriptView(), [
            ':module' => $this->module->key(),
        ]);
    }

    /**
     * Get the instance as an array.
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->buildName(),
            'script_view' => $this->buildScriptView(),
            'fields' => $this->getFields(),
            'default_settings' => $this->settings(),
        ];
    }
}