<?php

namespace Tests;

use App\Utils\SSH\Contracts\KeyGenerator;
use App\Utils\SSH\Contracts\KeyStorage as KeyStorageContract;
use App\Utils\SSH\Contracts\ProcessExecutor as ProcessExecutorContract;
use App\Utils\SSH\Shell\Response;
use App\Utils\SSH\Commands\SshKeygen;
use App\Utils\SSH\ValueObjects\KeyPair;
use App\Utils\SSH\ValueObjects\PrivateKey;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\Assert as PHPUnit;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Tests\Concerns\ServerEventFactory;
use Tests\Concerns\ServerFactory;
use Tests\Concerns\ServerFirewallFactory;
use Tests\Concerns\ServerKeyFactory;
use Tests\Concerns\TaskFactory;
use Tests\Concerns\UserFactory;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        ServerFactory,
        TaskFactory,
        UserFactory,
        ServerKeyFactory,
        ServerEventFactory,
        ServerFirewallFactory;

    protected function setUp(): void
    {
        parent::setUp();

        TestResponse::mixin(new TestResponseMixins());

        $this->instance(ProcessExecutorContract::class, new FakeProcessExecutor());

        $this->mock(KeyStorageContract::class, function($mock) {
            $mock->shouldReceive('storeKey')->andReturn('path to the file');
        });

        $this->mock(KeyGenerator::class, function($mock) {
            $mock->shouldReceive('generateForServer')->andReturnUsing(function() {

                return new KeyPair(
                    $this->getPublicKey(),
                    $this->getPrivateKey(),
                    Str::random()
                );

            });
        });
    }

    /**
     * @return string
     */
    public function callbackUrl(): string
    {
        return URL::signedRoute('callback');
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
