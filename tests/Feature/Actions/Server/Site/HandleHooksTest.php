<?php

namespace Tests\Feature\Actions\Server\Site;

use Tests\TestCase;

class HandleHooksTest extends TestCase
{
    // Test hook from github should be received with 200 status
    // Push hook from github with required branch should run deployment
    // Push hook from github without required branch should not run deployment
    // Push hook from bitbucket with required branch should run deployment
    // Push hook from bitbucket without required branch should not run deployment
    // Unregistered events should be skipped


}
