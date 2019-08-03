<?php

namespace Tests\Unit\Utils\Ssh;

use App\Utils\Ssh\CommandGenerator;
use Tests\TestCase;

class CommandGeneratorTest extends TestCase
{
    function test_command_for_script_should_be_generated()
    {
        $generator = new CommandGenerator('127.0.0.1', 22, '~/.ssh/id_rsa', 'root');

        $this->assertEquals(
            'ssh -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -i ~/.ssh/id_rsa -p 22 root@127.0.0.1 echo "hello world"',
            $generator->forScript('echo "hello world"')
        );
    }

    function test_command_for_upload_should_be_generated()
    {
        $generator = new CommandGenerator('127.0.0.1', 22, '~/.ssh/id_rsa', 'root');

        $this->assertEquals(
            'scp -i ~/.ssh/id_rsa -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no -o PasswordAuthentication=no -P 22 ~/file root@127.0.0.1:/root',
            $generator->forUpload('~/file', '/root')
        );
    }
}
