<?php

namespace App\Scripts\Utils;

use App\Utils\SSH\Script;

class GetCurrentDirectory extends Script
{
    /**
     * The displayable name of the script.
     *
     * @var string
     */
    protected $name = 'Echoing Current Directory';

    /**
     * Get the timeout for the script.
     *
     * @return int|null
     */
    public function getTimeout(): int
    {
        return 10;
    }

    /**
     * Get the script string
     *
     * @return string
     */
    public function getScript(): string
    {
        return 'pwd';
    }
}
