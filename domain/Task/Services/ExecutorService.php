<?php

namespace Domain\Task\Services;

use App\Scripts\Server\Callback;
use Domain\Task\Contracts\ExecutorService as ExecutorServiceContract;
use Domain\Task\Contracts\Task;
use Domain\SSH\Contracts\ProcessExecutor;
use Domain\SSH\Services\ScriptsStorage;
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
     *
     * @throws \Throwable
     */
    public function run(Task $task): void
    {
        $this->task = $task;

        $this->task->markAsRunning();

        $this->ensureWorkingDirectoryExists();

        try {
            $this->upload(true);
        } catch (ProcessTimedOutException $e) {
            $this->task->markAsTimedOut(
                $e->getMessage()
            );
            return;
        }

        $this->task->saveResponse(
            $response = $this->runInline(
                sprintf('bash %s 2>&1 | tee %s', $this->task->scriptFile(), $this->task->outputFile()),
                $this->options['timeout'] ?? 600
            )
        );

        (new FinishService($this->executor))->finish($this->task, $response->getExitCode());
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
            $this->task->markAsTimedOut(
                $e->getMessage()
            );
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
     * @param bool $callback
     * @return bool
     */
    protected function upload(bool $callback = true): bool
    {
        $process = $this->toUploadProcess(
            $localScript = $this->writeScript($callback),
            $this->task->scriptFile()
        );

        $response = $this->executor->run($process);

        @unlink($localScript);

        return $response->isSuccess();
    }

    /**
     * Write the script to storage in preparation for upload.
     *
     * @param bool $callback
     * @return string
     */
    protected function writeScript(bool $callback = true): string
    {
        $storage = app(ScriptsStorage::class);

        return $storage->storeScript(
            (string) new \App\Scripts\Server\Task(
                $this->task,
                $callback
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
