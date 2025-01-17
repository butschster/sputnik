<?php

namespace Domain\Module\Entities;

use Domain\Module\Contracts\Entities\Module;
use Domain\Module\Contracts\Entities\Action as ActionContract;
use Domain\Module\Events\Action\Ran;
use Domain\Task\Jobs\Run;
use App\Meta\FieldsCollection;
use App\Models\Server;
use App\Scripts\Server\CustomScript;
use Domain\Task\Factory;

class Action implements ActionContract, ActionContract\HasFields
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
     * @var array
     */
    protected $preparedScriptsData;

    /**
     * @var array
     */
    protected $preparedDatabaseData;

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
     * Get module
     *
     * @return Module
     */
    public function getModule(): Module
    {
        return $this->module;
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
    public function fields(): array
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
     * @return Server\Action
     * @throws \Throwable
     */
    public function run(Server $server, array $data = [], array $callbacks = []): Server\Action
    {
        $task = $this->createTaskForScript(
            $server, $data
        );

        $action = $this->storeActionToDatabase($server, $data, $task);

        foreach (array_merge($callbacks, $this->callbacks) as $callback) {
            $task->addCallback($callback);
        }

        dispatch_now(new Run($task));

        event(
            new Ran(
                $server,
                $this->module,
                $this,
                $this->preparedDatabaseData($server, $data)
            )
        );

        return $action;
    }

    /**
     * @param Server $server
     * @param array $data
     * @return array|mixed
     */
    public function preparedScriptData(Server $server, array $data)
    {
        if (!$this->preparedScriptsData) {
            $this->preparedScriptsData = $this->prepareScriptData($server, $data);
        }

        return $this->preparedScriptsData;
    }

    /**
     * @param Server $server
     * @param array $data
     * @return array|mixed
     */
    public function preparedDatabaseData(Server $server, array $data)
    {
        if (!$this->preparedDatabaseData) {
            $this->preparedDatabaseData = $this->prepareDatabaseData($server, $data);
        }

        return $this->preparedDatabaseData;
    }

    /**
     * @param Server $server
     * @param array $data
     *
     * @return array
     */
    protected function prepareDatabaseData(Server $server, array $data): array
    {
        $extensionsData = [];

        foreach ($this->extensions as $extension) {
            $extensionsData = array_merge(
                $extensionsData,
                $extension->databaseData($this->module, $server, $data),
            );
        }

        return array_merge(
            $data,
            $extensionsData
        );
    }

    /**
     * @param Server $server
     * @param array $data
     *
     * @return array
     */
    protected function prepareScriptData(Server $server, array $data): array
    {
        $data = array_merge(
            $data, $this->preparedDatabaseData($server, $data)
        );

        $extensionsData = [];

        foreach ($this->extensions as $extension) {
            $extensionsData = array_merge(
                $extensionsData,
                $extension->scriptData($this->module, $server, $data)
            );
        }

        return array_merge(
            $this->settings(),
            $data,
            $extensionsData
        );
    }

    /**
     * @param Server $server
     * @param array $data
     * @return \Domain\Task\Contracts\Task
     * @throws \Throwable
     */
    protected function createTaskForScript(Server $server, array $data): \Domain\Task\Contracts\Task
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
            $this->preparedScriptData($server, $data),
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

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->module->key().'.'.$this->key();
    }

    /**
     * Store information about current action to the database
     *
     * @param Server $server
     * @param array $data
     * @param \Domain\Task\Contracts\Task $task
     * @return Server\Action
     */
    protected function storeActionToDatabase(Server $server, array $data, \Domain\Task\Contracts\Task $task): Server\Action
    {
        $action = new Server\Action([
            'module' => $this->module,
            'class' => get_class($this),
            'action' => $this->key,
            'meta' => $this->preparedDatabaseData($server, $data),
        ]);

        $action->server()->associate($server);
        $action->save();

        $task->owner()->associate($action);
        $task->save();

        return $action;
    }
}
