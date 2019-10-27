<?php

namespace Tests\Unit\Rules\Server\Site;

use Domain\Site\Validation\Rules\PublicPath;
use Tests\TestCase;

class PublicPathTest extends TestCase
{
    /**
     * @dataProvider gitUrlsDataProvider
     *
     * @param $url
     * @param $passed
     */
    function test_validation($path, $passed)
    {
        $rule = new PublicPath();

        $this->assertEquals($passed, $rule->passes('field', $path));
    }

    public function gitUrlsDataProvider()
    {
        return [
            [
                'public',
                false,
            ],
            [
                '/public',
                true,
            ],
            [
                '/public/folder',
                true
            ],
            [
                '/public_folder',
                true
            ],
            [
                '/public-folder',
                false
            ],
            [
                '/public /folder',
                false
            ],
            [
                '/public path/folder',
                false
            ],
            [
                '/',
                true
            ]
        ];
    }
}
