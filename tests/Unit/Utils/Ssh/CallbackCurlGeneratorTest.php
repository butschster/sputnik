<?php

namespace Tests\Unit\Utils\Ssh;

use App\Utils\SSH\CallbackCurlGenerator;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CallbackCurlGeneratorTest extends TestCase
{
    function test_curl_string_can_ve_generated()
    {
        Carbon::setTestNow('2010-10-10');

        $generator = new CallbackCurlGenerator();

        $string = $generator->generate('server.configured', ['server' => 'server-id', 'exit_code' => '$STATUS']);

        $this->assertEquals(
            'curl-X POST -k -H "Content-Type: application/json" -d "server=server-id&exit_code=%24STATUS&action=server.configured" http://localhost/callback?action=server.configured&expires=1286672400&signature=4390de16b3bbdc36e3f5a3cd84cfcecd53d28c93d196f79d89927160542addb9 > /dev/null 2>&1',
            $string
        );
    }
}
