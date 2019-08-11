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

    function test_get_domain_url()
    {
        $site = $this->createServerSite([
            'domain' => 'site.com'
        ]);

        $this->assertEquals('http://site.com', $site->url());
    }

    function test_get_domain_secure_url()
    {
        $site = $this->createServerSite([
            'domain' => 'site.com'
        ]);

        $this->assertEquals('https://site.com', $site->secureUrl());
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
            'public_dir' => '/public'
        ]);

        $site->token = 'abc';

        $this->assertEquals(
            'http://localhost/callback?action=hook&signature=e45cf8a080ce2c501b298bae35e23eb43693d5dbb19b8903c6ddbc2e85e7af4a&token=abc&site_id=uuid',
            $site->hooksHandlerUrl()
        );
    }

    function test_it_has_server()
    {
        $site = $this->createServerSite();

        $this->assertInstanceOf(Server::class, $site->server);
    }

    function test_it_has_deployments()
    {
        $site = $this->createServerSite();

        $deployment = $this->createServerSiteDeployment([
            'server_site_id' => $site->id,
        ]);
        $deployment1 = $this->createServerSiteDeployment([
            'server_site_id' => $site->id,
        ]);
        $deployment2 = $this->createServerSiteDeployment();

        $this->assertTrue($site->deployments->contains($deployment));
        $this->assertTrue($site->deployments->contains($deployment1));
        $this->assertFalse($site->deployments->contains($deployment2));
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
