<?php

namespace Tests\Unit\Rules\Server;

use App\Validation\Rules\Server\CronExpression;
use Tests\TestCase;

class CronExpressionTest extends TestCase
{
    /**
     * @dataProvider cronExpressionsDataProvider
     *
     * @param string $expression
     * @param $expects
     */
    function test_validation(string $expression, $expects)
    {
        $this->assertEquals($expects, $this->getCronExpression()->passes('', $expression));
    }

    function test_validation_message()
    {
        $this->markTestSkipped('Specify validation message for this rule');
    }

    function cronExpressionsDataProvider()
    {
        return [
            ['', false],
            ['@yearly', true],
            ['@annually', true],
            ['0 0 1 1 *', true],
            ['@monthly', true],
            ['0 0 1 * *', true],
            ['@weekly', true],
            ['0 0 * * 0', true],
            ['@daily', true],
            ['0 0 * * *', true],
            ['@hourly', true],
            ['0 * * * *', true],
            ['15 10,13 * * 1,4', true],
            ['0-59/2 * * * *', true],
            ['0 22 * * 1-5', true],
        ];
    }

    /**
     * @return CronExpression
     */
    protected function getCronExpression()
    {
        return new CronExpression();
    }

}
