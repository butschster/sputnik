<?php

namespace App\Http\Controllers;

use App\Jobs\Task\Finish;
use App\Models\Server\Task;
use Illuminate\Http\Request;

class ServerTaskCallbackController extends Controller
{
    /**
     * @param Request $request
     * @param Task $task
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request, Task $task)
    {
        abort_unless($task->isRunning(), 404);

//        $this->validate($request, [
//            'exit_code' => 'required|numeric',
//        ]);

        dispatch(
            new Finish($task, (int) $request->exit_code)
        );
    }
}
