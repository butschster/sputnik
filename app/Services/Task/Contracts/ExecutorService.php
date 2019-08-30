<?php

namespace App\Services\Task\Contracts;

interface ExecutorService
{
    /**
     * Run task
     *
     * @param Task $task
     */
    public function run(Task $task): void;

    /**
     * Run the given script in the background on a remote server by using nohup.
     * https://en.wikipedia.org/wiki/Nohup
     *
     * @param Task $task
     *
     * @throws \Throwable
     */
    public function runInBackground(Task $task): void;
}