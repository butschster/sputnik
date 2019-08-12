<?php

namespace Tests\Unit\Rules\Server\Site;

use App\Validation\Rules\Server\Site\RepositoryUrl;
use Tests\TestCase;

class RepositoryUrlTest extends TestCase
{
    /**
     * @dataProvider gitUrlsDataProvider
     *
     * @param $url
     * @param $passed
     */
    function test_validation($url, $passed)
    {
        $rule = new RepositoryUrl();

        $this->assertEquals($passed, $rule->passes('field', $url));
    }

    public function gitUrlsDataProvider()
    {
        return [
            [
                'https://moylop260@bitbucket.org/moylop260/odoo-mexico.git',
                true,
            ],
            [
                'git@bitbucket.org:moylop260/odoo-mexico.git',
                true,
            ],
            [
                'git@github.com:moylop_260/odoo_mexico.git',
                true
            ],
            [
                'git@github.com:odoo-mexico/odoo_mexico.git',
                true
            ],
            [
                'git@github.com:moylop_260/odoo_mexico.git/',
                false
            ],
            [
                'git@github.com:odoo-mexico/odoo_mexico.git/',
                false
            ],
            [
                'git@github.com:odoo-mexico/odoo-mexico.git/',
                false
            ],
            [
                'git@github.com:odoo/odoo.git',
                true
            ]
        ];
    }
}
