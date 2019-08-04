<?php

namespace App\Services\Task\Contracts;

use App\Utils\Ssh\Shell\Response;
use Illuminate\Support\Collection;

interface Task
{
    /**
     * Mark the task as running.
     */
    public function markAsRunning();

    /**
     * Mark the task as finished.
     *
     * @param int $exitCode
     * @param string $output
     */
    public function markAsFinished(int $exitCode = 0, string $output = '');

    /**
     * Mark the task as timed out.
     *
     * @param string $output
     */
    public function markAsTimedOut(string $output = '');

    /**
     * Update the task for the given SSH response.
     *
     * @param Response $response
     */
    public function saveResponse(Response $response);

    /**
     * Get the maximum execution time for the task.
     *
     * @return int
     */
    public function timeout(): int;

    /**
     * Get the task options
     *
     * @return array
     */
    public function options(): array;

    /**
     * Get the task callbacks
     *
     * @return Collection
     */
    public function callbacks(): Collection;

    /**
     * Get the task script
     *
     * @return string
     */
    public function script(): string;

    /**
     * Get the remote working directory path for the task.
     *
     * @return string
     */
    public function path(): string;

    /**
     * Get the task user
     *
     * @return string
     */
    public function user(): string;

    /**
     * Get the server IP address
     *
     * @return string
     */
    public function serverIpAddress(): string;

    /**
     * Get the server SSH port
     *
     * @return int
     */
    public function serverPort(): int;

    /**
     * Get the path to the server owner's worker SSH key.
     *
     * @return string
     */
    public function serverKeyPath(): string;

    /**
     * Get the remote path to the script.
     *
     * @return string
     */
    public function scriptFile(): string;

    /**
     * Get the remote path to the output.
     *
     * @return string
     */
    public function outputFile(): string;
}
