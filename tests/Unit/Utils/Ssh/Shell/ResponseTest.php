<?php

namespace Tests\Unit\Utils\Ssh\Shell;

use App\Utils\SSH\Shell\Response;
use Tests\TestCase;

class ResponseTest extends TestCase
{
    function test_get_output()
    {
        $response = new Response(0, 'output string');

        $this->assertEquals('output string', $response->getOutput());
    }

    function test_get_exit_code()
    {
        $response = new Response(0, 'output string');

        $this->assertEquals(0, $response->getExitCode());

        $response = new Response(1, 'output string');
        $this->assertEquals(1, $response->getExitCode());
    }

    function test_response_is_timeout()
    {
        $response = new Response(0, 'output string');
        $this->assertFalse($response->isTimedOut());

        $response = new Response(0, 'output string', true);
        $this->assertTrue($response->isTimedOut());
    }

    function test_response_is_success()
    {
        $response = new Response(0, 'output string');
        $this->assertTrue($response->isSuccess());

        $response = new Response(1, 'output string');
        $this->assertFalse($response->isSuccess());
    }
}
