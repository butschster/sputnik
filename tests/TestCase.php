<?php

namespace Tests;

use App\Utils\Ssh\ProcessRunner;
use App\Utils\Ssh\Shell\Response;
use App\Utils\Ssh\Commands\SshKeygen;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function mockSshGenerator()
    {
        $this->instance(SshKeygen::class, new SshKeygenMock(new ProcessRunner()));
        $this->spy(Filesystem::class, function ($mock) {
            $mock->shouldReceive('get')->twice()->andReturn('key');
            $mock->shouldReceive('delete')->twice();
        });
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
