<?php

namespace Tests\Unit\Models\User;

use App\Models\Server;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SourceProviderTest extends TestCase
{
    use DatabaseMigrations;

    function test_get_user()
    {
        $provider = $this->createSourceProvider();
        $this->assertInstanceOf(User::class, $provider->user);
    }
}
