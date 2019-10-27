<?php

namespace Domain\SSH\Contracts;

interface Key
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * Get public key content
     *
     * @return string
     */
    public function getContents(): string;

    /**
     * Get path of private key file
     *
     * @return string
     */
    public function getPath(): string;
}