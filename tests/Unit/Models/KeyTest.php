<?php

namespace Tests\Unit\Models;

use App\Events\Server\Key\AttachedToServer;
use App\Events\Server\Key\DetachedFromServer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class KeyTest extends TestCase
{
    use DatabaseMigrations;

    function test_gets_fingerprint()
    {
        $key = $this->createSSHKey([
            'content' => $this->getPublicKey()
        ]);

        $this->assertEquals('b7:97:56:7d:10:11:8e:83:db:ab:2c:1f:33:98:30:3d', $key->fingerprint());
    }
}
