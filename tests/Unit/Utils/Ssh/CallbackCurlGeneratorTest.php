<?php

namespace Tests\Unit\Utils\Ssh;

use App\Contracts\Request\RequestSignatureHandler;
use Domain\SSH\Bash\CallbackCurlGenerator;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class CallbackCurlGeneratorTest extends TestCase
{
    function test_curl_string_can_ve_generated()
    {
        Carbon::setTestNow('2010-10-10');

        $generator = new CallbackCurlGenerator(
            $this->app[RequestSignatureHandler::class]
        );

        $string = $generator->generate('server.configured', ['server' => 'server-id', 'exit_code' => '$STATUS']);

        $this->assertEquals(
            'curl -X POST -k -d "server=server-id&exit_code=$STATUS&action=server.configured&expires=1286672400&signature=eac0783f2aa907864ceda664f01dfbff00fe672f0c05fd34d032fcdf64fd6c40" http://localhost/callback > /dev/null 2>&1',
            $string
        );
    }
}
