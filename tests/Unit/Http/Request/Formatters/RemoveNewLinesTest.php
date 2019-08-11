<?php

namespace Tests\Unit\Http\Request\Formatters;

use App\Http\Requests\Formatters\RemoveNewLines;
use Tests\TestCase;

class RemoveNewLinesTest extends TestCase
{
    function test_new_lines_should_be_removed()
    {
        $formatter = new RemoveNewLines();

        $this->assertEquals('Hello world', $formatter->apply("Hello \nworld"));
        $this->assertEquals('Hello world', $formatter->apply("Hello \rworld"));
        $this->assertEquals('Hello world', $formatter->apply("Hello \n\rworld"));
    }
}
