<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BitbucketLoginControllerTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_guest_can_be_redirected()
    {
        $response = $this->get(route('login.bitbucket'))
            ->assertRedirect();

        $this->assertStringContainsString(
            'https://bitbucket.org/site/oauth2/authorize?client_id=BITBUCKET_CLIENT_ID&redirect_uri=BITBUCKET_CALLBACK_URL&scope=&response_type=code',
            $response->headers->get('Location')
        );
    }

    function test_a_guest_without_connected_bitbucket_should_see_not_found()
    {
        $this->mockSocialite('bitbucket');

        $response = $this->get(route('login.bitbucket.callback'))->assertNotFound();
    }

    function test_a_guest_with_connected_bitbucket_should_be_autorized()
    {
        $provider = $this->createSourceProvider([
            'type' => 'bitbucket',
            'provider_user_id' => 'user-id',
            'access_token' => 'token-current'
        ]);

        $this->mockSocialite('bitbucket');

        $this->get(route('login.bitbucket.callback'))->assertRedirect('http://localhost/profile');

        $this->assertEquals('token-hash', $provider->refresh()->access_token);
    }

    function test_an_authenticated_user_without_provider_should_connect_a_new_one()
    {
        $user = $this->signIn();

        $this->assertCount(0, $user->sourceProviders);
        $this->mockSocialite('bitbucket');

        $this->get(route('login.bitbucket.callback'))->assertRedirect('http://localhost/profile');

        $provider = $user->sourceProviders()->first();

        $this->assertEquals('token-hash', $provider->access_token);
        $this->assertEquals('user-id', $provider->provider_user_id);
        $this->assertEquals('bitbucket', $provider->type);
    }

    function test_an_authenticated_user_with_provider_should_update_it()
    {
        $provider = $this->createSourceProvider([
            'type' => 'bitbucket',
            'provider_user_id' => 'user-id',
            'access_token' => 'token-current'
        ]);

        $user = $this->signIn($provider->user);
        $this->assertEquals('token-current', $user->sourceProviders->first()->access_token);

        $this->assertCount(1, $user->sourceProviders);
        $this->mockSocialite('bitbucket');

        $this->get(route('login.bitbucket.callback'))->assertRedirect('http://localhost/profile');

        $provider = $user->sourceProviders()->first();

        $this->assertEquals('token-hash', $provider->access_token);
    }
}
