<?php

namespace App\Utils\Ssh\Shell;

class Response
{
    /**
     * @var int
     */
    protected $exitCode;

    /**
     * @var string
     */
    protected $output;

    /**
     * @var bool
     */
    protected $timedOut;

    /**
     * Create a new response instance.
     *
     * @param  int  $exitCode
     * @param  string  $output
     * @param  bool  $timedOut
     * @return void
     */
    public function __construct(int $exitCode, string $output, bool $timedOut = false)
    {
        $this->exitCode = $exitCode;
        $this->output = $output;
        $this->timedOut = $timedOut;
    }

    /**
     * @return string
     */
    public function getOutput(): string
    {
        return $this->output;
    }

    /**
     * @return int
     */
    public function getExitCode(): int
    {
        return $this->exitCode;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->getExitCode() === 0;
    }

    /**
     * @return bool
     */
    public function isTimedOut(): bool
    {
        return $this->timedOut;
    }
}
