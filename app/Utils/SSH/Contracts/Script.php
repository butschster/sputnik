<?php

namespace App\Utils\SSH\Contracts;

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
     * Get the contents of the script.
     *
     * @return string
     */
    public function getScript(): string;

    public function __toString();
}
