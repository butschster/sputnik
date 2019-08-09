<?php

namespace Tests\Unit\Models\Server;

use App\Events\Server\Site\Created;
use App\Events\Server\Site\Deleted;
use App\Models\Server;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_random_token_should_be_generated_when_site_is_creating()
    {
        $site = $this->createServerSite();

        $this->assertNotNull($site->token);
    }

    function test_get_default_branch_if_it_is_not_set()
    {
        $site = $this->createServerSite([
            'repository_branch' => null,
        ]);

        $this->assertEquals('master', $site->repositoryBranch());
    }

    function test_get_branch_if_it_is_set()
    {
        $site = $this->createServerSite([
            'repository_branch' => 'test',
        ]);

        $this->assertEquals('test', $site->repositoryBranch());
    }

    function test_get_project_path()
    {
        $site = $this->createServerSite([
            'domain' => 'site.com',
        ]);

        $this->assertEquals('/var/www/site.com', $site->path());
    }

    function test_get_project_public_path()
    {
        $site = $this->createServerSite([
            'domain' => 'site.com',
            'public_dir' => '/public',
        ]);

        $this->assertEquals('/var/www/site.com/current/public', $site->publicPath());
    }

    function test_get_hooks_handler_url()
    {
        $site = $this->createServerSite([
            'id' => 'uuid',
            'domain' => 'site.com',
            'public_dir' => '/public',
        ]);

        $this->assertEquals(
            'http://localhost/callback?site_id=uuid&action=hook&signature=ed9a5f8d8e87dbb338c0d1127b93b25900181bc4912b05f105006a894674aa25',
            $site->hooksHandlerUrl()
        );
    }

    function test_it_has_server()
    {
        $site = $this->createServerSite();

        $this->assertInstanceOf(Server::class, $site->server);
    }

    function test_an_event_should_be_fired_when_site_created()
    {
        Event::fake(Created::class);

        $site = $this->createServerSite();

        Event::assertDispatched(Created::class, function ($event) use ($site) {
            return $site->is($event->site);
        });
    }

    function test_an_event_should_be_fired_when_site_deleted()
    {
        Event::fake(Deleted::class);

        $site = $this->createServerSite();

        $site->delete();

        Event::assertDispatched(Deleted::class, function ($event) use ($site) {
            return $site->is($event->site);
        });
    }
}
