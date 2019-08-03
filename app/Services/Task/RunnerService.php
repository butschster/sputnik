<?php

namespace App\Services\Task;

use App\Services\Task\Contracts\Task;
use App\Utils\Ssh\CommandGenerator;
use App\Utils\Ssh\ProcessRunner;
use App\Utils\Ssh\Shell\Response;
use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Symfony\Component\Process\Process;

class RunnerService
{
    /**
     * @var Task
     */
    protected $task;

    /**
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function run()
    {
        $this->task->markAsRunning();

        $this->ensureWorkingDirectoryExists();

        try {
            $this->upload();
        } catch (ProcessTimedOutException $e) {
            return $this->task->markAsTimedOut();
        }

        return $this->task->saveResponse(
            $this->runInline(
                sprintf('bash %s 2>&1 | tee %s', $this->task->scriptFile(), $this->task->outputFile()),
                $this->options['timeout'] ?? 60
            )
        );
    }

    /**
     * Upload the given script to the server.
     *
     * @return bool
     */
    protected function upload()
    {
        $process = $this->toUploadProcess(
            $localScript = $this->writeScript(),
            $this->task->scriptFile()
        );

        $response = $this->getProcessRunner()->run($process);

        @unlink($localScript);

        return $response->isSuccess();
    }

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

        return $this->getProcessRunner()->run(
            $this->toScriptProcess('\'bash -s \' << \'' . $token . '\'' . $script . '' . $token, $timeout)
        );
    }

    /**
     * Write the script to storage in preparation for upload.
     *
     * @return string
     */
    protected function writeScript(): string
    {
        $hash = md5(Str::random(20) . $this->task->script());

        return tap(storage_path('app/scripts') . '/' . $hash, function ($path) {
            file_put_contents($path, $this->task->script());
        });
    }


    /**
     * Create the remote working directory for the task.
     *
     * @return void
     */
    protected function ensureWorkingDirectoryExists()
    {
        $this->runInline('mkdir -p ' . $this->task->path(), 10);
    }

    /**
     * @param string $script
     * @param int $timeout
     * @return Process
     */
    protected function toScriptProcess(string $script, int $timeout): Process
    {
        return $this->toProcess(
            $this->getCommandGenerator()->forScript($script),
            $timeout
        );
    }

    /**
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
     * @param string $script
     * @param int $timeout
     * @param string|null $cwd
     * @return Process
     */
    protected function toProcess(string $script, int $timeout, ?string $cwd = null): Process
    {
        return (new Process((array) $script, $cwd))->setTimeout($timeout);
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

    /**
     * @return ProcessRunner
     */
    protected function getProcessRunner(): ProcessRunner
    {
        return new ProcessRunner;
    }
}
