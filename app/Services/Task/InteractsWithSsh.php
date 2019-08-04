<?php

namespace App\Services\Task;

use App\Services\Task\Contracts\Task;
use App\Utils\Ssh\CommandGenerator;
use App\Utils\Ssh\Shell\Response;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

trait InteractsWithSsh
{
    /**
     * @var Task
     */
    protected $task;

    /**
     * Run a given script inline on the remote server.
     *
     * @param string $script
     * @param int $timeout
     * @return Response
     */
    protected function runInline(string $script, int $timeout = 60): Response
    {
        $token = Str::random(20);

        return $this->processRunner->run(
            $this->toScriptProcess(['bash', '-s', '<<', $token . '
' . $script . '
' . $token,
            ], $timeout),
            function ($type, $buffer) {
                if (Process::ERR === $type) {
                    echo 'ERR > ' . $buffer;
                } else {
                    echo 'OUT > ' . $buffer;
                }
            });
    }

    /**
     * Create a script Process instance.
     *
     * @param array|string $script
     * @param int $timeout
     * @return Process
     */
    protected function toScriptProcess($script, int $timeout): Process
    {
        return $this->toProcess(
            $this->getCommandGenerator()->forScript($script),
            $timeout
        );
    }

    /**
     * Create an upload Process instance via SCP.
     *
     * @param string $from
     * @param string $to
     * @return Process
     */
    protected function toUploadProcess(string $from, string $to): Process
    {
        return $this->toProcess(
            $this->getCommandGenerator()->forUpload($from, $to),
            15,
            base_path()
        );
    }

    /**
     * Create a Process instance for the given script.
     *
     * @param string|array $script
     * @param int $timeout
     * @param string|null $cwd
     * @return Process
     */
    protected function toProcess($script, int $timeout, ?string $cwd = null): Process
    {
        return (new Process($script, $cwd))->setTimeout($timeout);
    }

    /**
     * @return CommandGenerator
     */
    protected function getCommandGenerator(): CommandGenerator
    {
        return new CommandGenerator(
            $this->task->serverIpAddress(),
            $this->task->serverPort(),
            $this->task->serverKeyPath(),
            $this->task->user()
        );
    }
}
