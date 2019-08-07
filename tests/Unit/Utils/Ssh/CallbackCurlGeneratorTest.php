<?php

namespace Tests\Unit\Utils\Ssh;

use App\Utils\SSH\CallbackCurlGenerator;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CallbackCurlGeneratorTest extends TestCase
{
    function test_curl_string_can_ve_generated()
    {
        config()->set('app.key', '123');
        Carbon::setTestNow('2010-10-10');

        $generator = new CallbackCurlGenerator();

        $string = $generator->generate('server.configured', ['server' => 'server-id', 'exit_code' => '$STATUS']);

        $this->assertEquals(
            'curl -X POST -k -d "server=server-id&exit_code=$STATUS&action=server.configured&expires=1286672400&signature=084239b65442e89f79e93425c92ebf09bdd24c9bd888623ec72a6c681f3da4a2" http://localhost/callback > /dev/null 2>&1',
            $string
        );
    }
}
