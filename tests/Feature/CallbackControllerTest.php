<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CallbackControllerTest extends TestCase
{
    use DatabaseMigrations;

    function test_if_action_not_found_show_page_not_found()
    {
        $response = $this->sendCallbackRequest('non-exist-action-key');

        $response->assertStatus(404);
    }
}
