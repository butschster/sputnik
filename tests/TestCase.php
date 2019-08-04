<?php

namespace Tests;

use App\Models\Server;
use App\Services\Task\Contracts\Task;
use App\Services\Task\RunnerService;
use App\Utils\Ssh\ProcessRunner;
use App\Utils\Ssh\Shell\Response;
use App\Utils\Ssh\Commands\SshKeygen;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Symfony\Component\Process\Exception\ProcessTimedOutException;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->instance(RunnerService::class, new FakeRunnerService);
    }

    /**
     * Create a new server
     *
     * @param array $attributes
     * @param int $times
     * @return Server|Collection
     */
    public function createServer(array $attributes = [], int $times = null)
    {
        $this->mockSshGenerator();

        return $this->serverFactory($times)->create($attributes);
    }

    /**
     * Make a new server
     *
     * @param array $attributes
     * @param int $times
     * @return Server|Collection
     */
    public function makeServer(array $attributes = [], int $times = null)
    {
        return $this->serverFactory($times)->make($attributes);
    }

    /**
     * @param int|null $times
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    public function serverFactory(int $times = null)
    {
        return factory(Server::class, $times);
    }

    /**
     * Create a new task
     *
     * @param array $attributes
     * @param int $times
     * @return Server\Task|Collection
     */
    public function createTask(array $attributes = [], int $times = null)
    {
        $this->mockSshGenerator();

        return $this->taskFactory($times)->create($attributes);
    }

    /**
     * Make a new task
     *
     * @param array $attributes
     * @param int $times
     * @return Server\Task|Collection
     */
    public function makeTask(array $attributes = [], int $times = null)
    {
        $this->mockSshGenerator();

        return $this->taskFactory($times)->make($attributes);
    }

    /**
     * @param int|null $times
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    public function taskFactory(int $times = null)
    {
        return factory(Server\Task::class, $times);
    }

    /**
     * Create a new server
     *
     * @param array $attributes
     * @param int $times
     * @return Server\Key|Collection
     */
    public function createServerKey(array $attributes = [], int $times = null)
    {
        return $this->serverKeyFactory($times)->create($attributes);
    }

    /**
     * Make a new server
     *
     * @param array $attributes
     * @param int $times
     * @return Server\Key|Collection
     */
    public function makeServerKey(array $attributes = [], int $times = null)
    {
        return $this->serverKeyFactory($times)->make($attributes);
    }

    /**
     * @param int|null $times
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    public function serverKeyFactory(int $times = null)
    {
        return factory(Server\Key::class, $times);
    }

    public function mockSshGenerator()
    {
        $this->instance(SshKeygen::class, new SshKeygenMock(new ProcessRunner()));
        $this->spy(Filesystem::class, function ($mock) {
            $mock->shouldReceive('get')->andReturn('key');
            $mock->shouldReceive('delete');
        });
    }

    /**
     * @return string
     */
    public function getPublicKey(): string
    {
        return trim(file_get_contents(
            base_path('tests/fixtures/Ssh/id_rsa.pub')
        ));
    }
}

class SshKeygenMock extends SshKeygen
{
    /**
     * @param string $name
     * @param string $password
     * @return Response
     */
    public function execute(string $name, string $password): Response
    {
        return new Response(0, '');
    }
}

class FakeRunnerService extends RunnerService
{
    public function __construct(){}

    /**
     * @param Task $task
     */
    public function run(Task $task)
    {
        $this->task = $task;

        $this->task->markAsRunning();

        return $this->task->saveResponse(
            new Response(0, 'done!')
        );
    }

    /**
     * Run the given script in the background on a remote server.
     *
     * @param Task $task
     * @return void
     */
    public function runInBackground(Task $task)
    {
        $this->task = $task;

        $this->task->markAsRunning();

        $this->addCallbackToScript();
    }
}
