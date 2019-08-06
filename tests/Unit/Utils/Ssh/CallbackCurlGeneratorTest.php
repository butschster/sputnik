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
            'curl -X POST -k -d "server=server-id&exit_code=$STATUS&action=server.configured&expires=1286672400&signature=4642cc6aa477ee9313d5fca309932210c545dd6106d1ea4e15799fec911b1f55" http://sputnik.superprojects.space/callback > /dev/null 2>&1',
            $string
        );
    }
}
