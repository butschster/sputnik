<?php

namespace Tests\Feature;

use App\Jobs\Server\ConfigureServer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class CallbackControllerTest extends TestCase
{
    use DatabaseMigrations;

    function test_if_action_not_found_show_page_not_found()
    {
        $response = $this->postJson($this->callbackUrl(), [
            'action' => 'non-exist-action-key',
        ]);

        $response->assertStatus(404);
    }
}
