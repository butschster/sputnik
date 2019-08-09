<?php

namespace Tests\Unit\Models\Server;

use App\Models\Server;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CronJobTest extends TestCase
{
    use DatabaseMigrations;

    function test_it_has_server()
    {
        $job = $this->makeCronJob();

        $this->assertInstanceOf(Server::class, $job->server);
    }

    /**
     * @dataProvider cronNamesProvider
     */
    function test_a_named_string_should_be_converted_to_cron_expression($name, $expression)
    {
        $job = $this->makeCronJob([
            'cron' => $name
        ]);

        $this->assertEquals($expression, $job->cron);
    }

    function cronNamesProvider()
    {
        return [
            [
                '@yearly',
                '0 0 1 1 *',
            ],
            [
                '@annually',
                '0 0 1 1 *',
            ],
            [
                '@monthly',
                '0 0 1 * *',
            ],
            [
                '@weekly',
                '0 0 * * 0',
            ],
            [
                '@daily',
                '0 0 * * *',
            ],
            [
                '@hourly',
                '0 * * * *',
            ],
        ];
    }
}
