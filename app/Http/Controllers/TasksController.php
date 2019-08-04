<?php

namespace App\Http\Controllers;

use App\Models\Server\Task;

class TasksController extends Controller
{
    /**
     * @param Task $task
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Task $task)
    {
        return view('task.show', compact('task'));
    }
}
