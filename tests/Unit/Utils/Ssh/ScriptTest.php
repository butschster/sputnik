<?php

namespace Tests\Unit\Utils\Ssh;

use App\Utils\SSH\Script;
use Tests\TestCase;

class ScriptTest extends TestCase
{

    function test_get_class_name_if_name_property_is_empty()
    {
        $script = new ScriptWithoutName();

        $this->assertEquals('Tests\Unit\Utils\Ssh\ScriptWithoutName', $script->getName());
    }

    function test_get_class_name_if_name_property_is_filled()
    {
        $script = new ScriptWithName();

        $this->assertEquals('Test name', $script->getName());
    }

    function test_get_default_timeout()
    {
        $script = new ScriptWithoutName();

        $this->assertEquals(Script::DEFAULT_TIMEOUT, $script->getTimeout());
    }

    function test_get_default_user_if_user_property_is_empty()
    {
        $script = new ScriptWithoutName();

        $this->assertEquals(Script::USER_ROOT, $script->getUser());
    }

    function test_get_specified_user_if_user_property_is_filled()
    {
        $script = new ScriptWithName();

        $this->assertEquals('test', $script->getUser());
    }

}

class ScriptWithoutName extends Script
{

    /**
     * Get the contents of the script.
     * @return string
     */
    public function getScript(): string
    {
        return 'script content';
    }
}

class ScriptWithName extends Script
{
    protected $name = 'Test name';

    protected $sshAs = 'test';

    /**
     * Get the contents of the script.
     * @return string
     */
    public function getScript(): string
    {
        return 'script content';
    }
}
