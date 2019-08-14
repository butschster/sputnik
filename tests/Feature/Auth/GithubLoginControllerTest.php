<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GithubLoginControllerTest extends TestCase
{
    use DatabaseMigrations;

    function test_a_guest_can_be_redirected()
    {
        $response = $this->get(route('login.github'))
            ->assertRedirect();

        $this->assertStringContainsString(
            'https://github.com/login/oauth/authorize?client_id=GITHUB_CLIENT_ID&redirect_uri=GITHUB_CALLBACK_URL&scope=repo%2Cwrite%3Apublic_key%2Cread%3Apublic_key%2Cadmin%3Arepo_hook&response_type=code',
            $response->headers->get('Location')
        );
    }

    function test_a_guest_without_connected_github_should_see_not_found()
    {
        $this->mockSocialite('github');

        $response = $this->get(route('login.github.callback'))->assertNotFound();
    }

    function test_a_guest_with_connected_github_should_be_autorized()
    {
        $provider = $this->createSourceProvider([
            'type' => 'github',
            'provider_user_id' => 'user-id',
            'access_token' => 'token-current'
        ]);

        $this->mockSocialite('github');

        $this->get(route('login.github.callback'))->assertRedirect('http://localhost/profile');

        $this->assertEquals('token-hash', $provider->refresh()->access_token);
    }

    function test_an_authenticated_user_without_provider_should_connect_a_new_one()
    {
        $user = $this->signIn();

        $this->assertCount(0, $user->sourceProviders);
        $this->mockSocialite('github');

        $this->get(route('login.github.callback'))->assertRedirect('http://localhost/profile');

        $provider = $user->sourceProviders()->first();

        $this->assertEquals('token-hash', $provider->access_token);
        $this->assertEquals('user-id', $provider->provider_user_id);
        $this->assertEquals('github', $provider->type);
    }

    function test_an_authenticated_user_with_provider_should_update_it()
    {
        $provider = $this->createSourceProvider([
            'type' => 'github',
            'provider_user_id' => 'user-id',
            'access_token' => 'token-current'
        ]);

        $user = $this->signIn($provider->user);
        $this->assertEquals('token-current', $user->sourceProviders->first()->access_token);

        $this->assertCount(1, $user->sourceProviders);
        $this->mockSocialite('github');

        $this->get(route('login.github.callback'))->assertRedirect('http://localhost/profile');

        $provider = $user->sourceProviders()->first();

        $this->assertEquals('token-hash', $provider->access_token);
    }
}
