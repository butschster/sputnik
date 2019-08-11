<?php

namespace Tests\Unit\Models\Server\Site;

use App\Models\Server;
use App\Models\Server\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeploymentTest extends TestCase
{
    use DatabaseMigrations;

    function test_it_has_site()
    {
        $deployment = $this->createServerSiteDeployment();

        $this->assertInstanceOf(Site::class, $deployment->site);
    }

    function test_it_has_initiator()
    {
        $deployment = $this->createServerSiteDeployment();

        $this->assertInstanceOf(User::class, $deployment->initiator);
    }
}
