<?php

namespace App\Scripts;

use App\Scripts\Contracts\Manager as ManagerContract;

class Manager implements ManagerContract
{
    /**
     * List of links tp scripts
     *
     * @var array
     */
    protected $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
}
