<?php

namespace Tests\Unit\Utils\Ssh\Shell;

use Domain\SSH\Shell\Output;
use Tests\TestCase;

class OutputTest extends TestCase
{
    function test_s_atring_should_be_stored()
    {
        $output = new Output();

        $output('type', 'hello world');

        $this->assertEquals('hello world', (string) $output);

        $output('type', 'Another string');
        $this->assertEquals('hello worldAnother string', (string) $output);
    }
}
