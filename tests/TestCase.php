<?php

namespace Tests;

use App\Contracts\Request\RequestSignatureHandler;
use App\Events\Task\Running;
use Domain\Task\Contracts\Task;
use Domain\Task\Services\ExecutorService;
use Domain\SSH\Bash\SshKeygen;
use Domain\SSH\Contracts\KeyGenerator;
use Domain\SSH\Contracts\KeyStorage as KeyStorageContract;
use Domain\SSH\Contracts\ProcessExecutor as ProcessExecutorContract;
use Domain\SSH\Contracts\Script;
use Domain\SSH\Shell\Response;
use Domain\SSH\ValueObjects\KeyPair;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use PHPUnit\Framework\Assert as PHPUnit;
use Symfony\Component\Process\Process;
use Tests\Concerns\CronJobFactory;
use Tests\Concerns\ServerDatabaseFactory;
use Tests\Concerns\ServerEventFactory;
use Tests\Concerns\ServerFactory;
use Tests\Concerns\ServerFirewallFactory;
use Tests\Concerns\ServerSiteDeploymentFactory;
use Tests\Concerns\ServerSiteFactory;
use Tests\Concerns\TaskFactory;
use Tests\Concerns\UserFactory;
use Tests\Concerns\UserSourceProviderFactory;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        ServerFactory,
        TaskFactory,
        UserFactory,
        ServerEventFactory,
        ServerFirewallFactory,
        CronJobFactory,
        ServerSiteFactory,
        ServerDatabaseFactory,
        ServerSiteDeploymentFactory,
        UserSourceProviderFactory;

    protected function setUp(): void
    {
        parent::setUp();

        TestResponse::mixin(new TestResponseMixins());

        $this->instance(ProcessExecutorContract::class, new FakeProcessExecutor());

        $this->mock(KeyStorageContract::class, function($mock) {
            $mock->shouldReceive('store')->andReturn('path to the file');
        });

        $this->mock(KeyGenerator::class, function($mock) {
            $mock->shouldReceive('generate')->andReturnUsing(function() {

                return new KeyPair(
                    $this->getPublicKey(),
                    $this->getPrivateKey(),
                    Str::random()
                );

            });
        });
    }

    /**
     * Send callback request
     *
     * @param string $action
     * @param array $parameters
     *
     * @return TestResponse
     */
    public function sendCallbackRequest(string $action, array $parameters = [])
    {
        $signatureHandler = $this->app[RequestSignatureHandler::class];

        $parameters = array_merge($parameters, $signatureHandler->signParameters(
            ['action' => $action]
        ));

        return $this->postJson(
            route('callback'),
            $parameters
        );
    }


    public function mockSshGenerator()
    {
        $this->instance(SshKeygen::class, new SshKeygenMock(new FakeProcessExecutor()));
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

    /**
     * @return string
     */
    public function getPrivateKey(): string
    {
        return trim(file_get_contents(
            base_path('tests/fixtures/Ssh/id_rsa')
        ));
    }

    public function spyRunningTasks()
    {
        Event::fake(Running::class);
    }

    /**
     * Check if specific tasks were run
     *
     * @param Task $task
     */
    public function assertTaskExecuted(Task $task)
    {
        Event::assertDispatched(Running::class, function ($event) use($task) {
            return $task->is($event->task);
        });
    }

    /**
     * Check if specific tasks were run
     *
     * @param Script $script
     */
    public function assertExecutedTaskScript(Script $script)
    {
        return $this->assertExecutedTaskScriptContains($script->getScript(), $script->getName());
    }

    /**
     * Check if specific tasks were run
     *
     * @param string $partOfScript
     * @param string|null $taskName
     */
    public function assertExecutedTaskScriptContains(string $partOfScript, string $taskName = null)
    {
        $event = Running::class;

        $events = Event::dispatched($event, function ($event) use($taskName) {
            // If method has task name, then filter tasks only with certain name
            if (!empty($taskName)) {
                return Str::contains($event->task->name, $taskName);
            }

            return true;
        })->filter(function($events) use($partOfScript) {
            // Check each task script and find needle string in it
            $event = $events[0];
            try {
                $this->assertStringContainsString($partOfScript, $event->task->script);
                return true;
            } catch (\SebastianBergmann\RecursionContext\InvalidArgumentException $e) {}

            return false;
        });

        PHPUnit::assertTrue(
            $events->count() > 0,
            "The expected [{$event}] event was not dispatched."
        );
    }

    /**
     * @param \Closure $callback
     */
    public function listenExecutorService(\Closure $callback)
    {
        $this->mock(ExecutorService::class, function ($mock) use($callback) {
            $mock->shouldReceive('run')->andReturnUsing(function (Task $task) use($callback) {
                $response = new Response(0, '');

                $callbackResponse = $callback($task);
                if ($callbackResponse instanceof Response) {
                    $response = $callbackResponse;
                }

                $task->saveResponse(
                    $response
                );
            });
        });
    }

    protected function mockSocialite(string $driver): void
    {
        $user = $this->mock('Laravel\Socialite\Two\User', function ($user) {
            $user->shouldReceive('getId')
                ->andReturn('user-id')
                ->set('token', 'token-hash');
        });

        $provider = $this->mock('Laravel\Socialite\Contracts\Provider', function ($provider) use ($user) {
            $provider->shouldReceive('user')->andReturn($user);
        });

        Socialite::shouldReceive('driver')->with($driver)->andReturn($provider);
    }
}

class SshKeygenMock extends SshKeygen
{
    /**
     * @param string $name
     * @param string $password
     * @return Response
     */
    public function execute(string $name, string $password = null): Response
    {
        return new Response(0, '');
    }
}

class FakeProcessExecutor implements ProcessExecutorContract
{

    /**
     * @param Process $process
     *
     * @return Response
     */
    public function run(Process $process): Response
    {
        return new Response(0, 'done!');
    }
}
