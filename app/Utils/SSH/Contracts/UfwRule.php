<?php

namespace App\Utils\SSH\Contracts;

interface UfwRule
{
    /**
     * Get the policy
     *
     * @return string
     */
    public function policy(): string;

    /**
     * Get the rule protocol
     *
     * @return string|null
     */
    public function protocol(): ?string;

    /**
     * Get the rule port
     *
     * @return string|null
     */
    public function port(): ?string;

    /**
     * Get the from
     *
     * @return string|null
     */
    public function from(): ?string;

    /**
     * Check if the port was set
     *
     * @return bool
     */
    public function hasFrom(): bool;

    /**
     * Check if the port was set
     *
     * @return bool
     */
    public function hasPort(): bool;

    /**
     * Check if the protocol was set
     *
     * @return bool
     */
    public function hasProtocol(): bool;

    /**
     * Generate bash command to enable rule
     *
     * @return string
     * @throws \Exception
     */
    public function toBashEnableCommand(): string;

    /**
     * Generate bash command to delete rule
     *
     * @return string
     * @throws \Exception
     */
    public function toBashDisableCommand(): string;
}
