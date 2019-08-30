<?php

namespace App\Services\Task;

use App\Scripts\Server\Callback;
use App\Services\Task\Contracts\ExecutorService as ExecutorServiceContract;
use App\Services\Task\Contracts\Task;
use App\Utils\SSH\Contracts\ProcessExecutor;
use App\Utils\SSH\ScriptsStorage;
use Symfony\Component\Process\Exception\ProcessTimedOutException;

class ExecutorService implements ExecutorServiceContract
{
    use InteractsWithSsh;

    /**
     * @var ProcessExecutor
     */
    protected $executor;

    /**
     * This service executes tasks
     *
     * @param ProcessExecutor $executor
     */
    public function __construct(ProcessExecutor $executor)
    {
        $this->executor = $executor;
    }

    /**
     * Run task
     *
     * @param Task $task
     */
    public function run(Task $task): void
    {
        $this->task = $task;

        $this->task->markAsRunning();

        $this->ensureWorkingDirectoryExists();

        try {
            $this->upload();
        } catch (ProcessTimedOutException $e) {
            $this->task->markAsTimedOut();
            return;
        }

        $this->task->saveResponse(
            $this->runInline(
                sprintf('bash %s 2>&1 | tee %s', $this->task->scriptFile(), $this->task->outputFile()),
                $this->options['timeout'] ?? 60
            )
        );
    }

    /**
     * Run the given script in the background on a remote server by using nohup.
     * https://en.wikipedia.org/wiki/Nohup
     *
     * @param Task $task
     *
     * @throws \Throwable
     */
    public function runInBackground(Task $task): void
    {
        $this->task = $task;

        $this->task->markAsRunning();

        $this->addCallbackToScript();

        $this->ensureWorkingDirectoryExists();

        try {
            $this->upload();
        } catch (ProcessTimedOutException $e) {
            $this->task->markAsTimedOut();
            return;
        }

        $this->executor->run(
            $this->toScriptProcess([
                'nohup', 'bash', $this->task->scriptFile(), '>>', $this->task->outputFile(), '2>&1', '&'
            ], 10)
        );
    }

    /**
     * Add a callback to the script.
     *
     * @return void
     * @throws \Throwable
     */
    protected function addCallbackToScript(): void
    {
        $callback = (new Callback($this->task))->getScript();

        $this->task->update([
            'script' => $callback,
        ]);
    }

    /**
     * Upload the given script to the server.
     *
     * @return bool
     */
    protected function upload(): bool
    {
        $process = $this->toUploadProcess(
            $localScript = $this->writeScript(),
            $this->task->scriptFile()
        );

        $response = $this->executor->run($process);

        @unlink($localScript);

        return $response->isSuccess();
    }

    /**
     * Write the script to storage in preparation for upload.
     *
     * @return string
     */
    protected function writeScript(): string
    {
        $storage = app(ScriptsStorage::class);

        return $storage->storeScript(
            (string) new \App\Scripts\Server\Task(
                $this->task
            )
        );
    }

    /**
     * Create the remote working directory for the task.
     *
     * @return void
     */
    protected function ensureWorkingDirectoryExists(): void
    {
        $this->runInline('mkdir -p ' . $this->task->path(), 10);
    }
}
