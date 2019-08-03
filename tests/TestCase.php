<?php

namespace Tests;

use App\Utils\Ssh\Shell\SshKeygen;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Symfony\Component\Process\Process;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function mockSshGenerator()
    {
        $this->instance(SshKeygen::class, new SshKeygenMock());
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
     * @return int
     */
    public function execute(string $name, string $password)
    {
        return 1;
    }
}
