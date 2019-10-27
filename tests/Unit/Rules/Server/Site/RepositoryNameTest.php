<?php

namespace Tests\Unit\Rules\Server\Site;

use Domain\SourceProvider\Validation\Rules\RepositoryName;
use Tests\TestCase;

class RepositoryNameTest extends TestCase
{
    /**
     * @dataProvider gitNamesDataProvider
     *
     * @param $name
     * @param $passed
     */
    function test_validation($name, $passed)
    {
        $rule = new RepositoryName();

        $this->assertEquals($passed, $rule->passes('field', $name));
    }

    public function gitNamesDataProvider()
    {
        return [
            [
                'moylop260/odoo-mexico',
                true,
            ],
            [
                'moylop_260/odoo_mexico',
                true,
            ],
            [
                'odoo-mexico/odoo_mexico',
                false,
            ],
            [
                'moylop_260',
                false,
            ],
            [
                'odoo mexico/odoo_mexico',
                false,
            ],
            [
                'odoo/mexico/odoo-mexico',
                false,
            ],
            [
                'odoo/odoo.git',
                false,
            ],
        ];
    }
}
