<?php

namespace App\Utils\Shell\Contracts;

interface Script
{
    /**
     * Get the name of the script.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the timeout for the script.
     *
     * @return int|null
     */
    public function getTimeout(): ?int;

    /**
     * Get the user that the script should be run as.
     *
     * @return string
     */
    public function getUser(): string;

    /**
     * Get the script string
     *
     * @return string
     */
    public function getScript(): string;
}
