<?php

namespace App\Models\Subscription;

use Carbon\Carbon;

class Period
{
    /**
     * Starting date of the period.
     *
     * @var string
     */
    protected $start;

    /**
     * Ending date of the period.
     *
     * @var string
     */
    protected $end;

    /**
     * Interval.
     *
     * @var string
     */
    protected $interval;

    /**
     * Interval count.
     *
     * @var int
     */
    protected $period = 1;

    /**
     * Create a new Period instance.
     *
     * @param string $interval
     * @param int $count
     * @param Carbon|null $start
     *
     * @return void
     */
    public function __construct(string $interval = 'month', int $count = 1, Carbon $start = null)
    {
        $this->interval = $interval;
        $this->start = $start ?: now();

        if ($count > 0) {
            $this->period = $count;
        }

        $start = clone $this->start;
        $method = 'add' . ucfirst($this->interval) . 's';
        $this->end = $start->{$method}($this->period);
    }

    /**
     * Get start date.
     *
     * @return \Carbon\Carbon
     */
    public function getStartDate(): Carbon
    {
        return $this->start;
    }

    /**
     * Get end date.
     *
     * @return \Carbon\Carbon
     */
    public function getEndDate(): Carbon
    {
        return $this->end;
    }

    /**
     * Get period interval.
     *
     * @return string
     */
    public function getInterval(): string
    {
        return $this->interval;
    }

    /**
     * Get period interval count.
     *
     * @return int
     */
    public function getIntervalCount(): int
    {
        return $this->period;
    }
}