<?php

namespace App\Events\Server\Site\Deployment;

use App\Models\Server\Site\Deployment;

class Timeout
{
    /**
     * @var Deployment
     */
    public $deployment;

    public function __construct(Deployment $deployment)
    {
        $this->deployment = $deployment;
    }
}