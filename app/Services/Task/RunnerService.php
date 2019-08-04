<?php

namespace App\Services\Task;

use App\Models\Server;
use App\Scripts\Server\Callback;
use App\Services\Task\Contracts\Task;
use App\Utils\Ssh\ProcessRunner;
use App\Utils\Ssh\ScriptsStorage;
use Symfony\Component\Process\Exception\ProcessTimedOutException;

class RunnerService
{
    use InteractsWithSsh;

    /**
     * @var ProcessRunner
     */
    protected $processRunner;

    /**
     * @param ProcessRunner $processRunner
     */
    public function __construct(ProcessRunner $processRunner)
    {
        $this->processRunner = $processRunner;
    }

    /**
     * @param Task $task
     */
    public function run(Task $task)
    {
        $this->task = $task;

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
     * Run the given script in the background on a remote server.
     *
     * @param Task $task
     * @return void
     */
    public function runInBackground(Task $task)
    {
        $this->task = $task;

        $this->task->markAsRunning();

        $this->addCallbackToScript();

        $this->ensureWorkingDirectoryExists();

        try {
            $this->upload();
        } catch (ProcessTimedOutException $e) {
            return $this->task->markAsTimedOut();
        }

        $this->processRunner->run(
            $this->toScriptProcess([
                'nohup', 'bash', $this->task->scriptFile(), '>>', $this->task->outputFile(), '2>&1', '&'
            ], 10)
        );
    }

    /**
     * Add a callback to the script.
     *
     * @return void
     */
    protected function addCallbackToScript()
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
    protected function upload()
    {
        $process = $this->toUploadProcess(
            $localScript = $this->writeScript(),
            $this->task->scriptFile()
        );

        $response = $this->processRunner->run($process);

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
            $this->task->script()
        );
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
}
