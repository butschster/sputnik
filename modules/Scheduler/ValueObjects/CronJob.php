<?php

namespace Module\Scheduler\ValueObjects;

class CronJob
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $command;

    /**
     * @var string
     */
    protected $cron;

    /**
     * @var string
     */
    protected $user;

    /**
     * @param string $name
     * @param string $command
     * @param string $cron
     * @param string $user
     */
    public function __construct(string $name, string $command, string $cron, string $user = 'root')
    {
        $this->name = $name;
        $this->command = $command;
        $this->cron = $cron;
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @return string
     */
    public function getCronExpression(): string
    {
        return $this->cron;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }
}
