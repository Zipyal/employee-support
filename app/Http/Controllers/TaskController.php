<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    const VALIDATION_RULES = [
        'status' => 'required',
        'type' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'description' => 'text',
    ];

    public function index(Request $request)
    {
        $tasks = Task::query()->get();

        return view('task.index', [
            'tasks' => $tasks,
        ]);
    }


    public function show(string $id)
    {
        return view('task.view', [
            'task' => Task::query()->findOrFail($id)
        ]);
    }

    public function add()
    {
        return view('task.edit', [
            'task' => new Task(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(self::VALIDATION_RULES);


        Task::query()->create($validated);

        return redirect()->route('task');
    }

    public function edit(string $id)
    {
        return view('task.edit', [
            'task' => Task::query()->findOrFail($id),
        ]);
    }

    public function update(Request $request, string $id)
    {
        /** @var Task $task */
        $task = Task::query()->findOrFail($id);
        $validated = $request->validate(self::VALIDATION_RULES);
        $task->update($validated);
        return redirect()->route('task');
    }

    public function delete($id)
    {
        /** @var Task $task */
        $task = Task::query()->findOrFail($id);
        $task->delete();
        return redirect()->route('task');
    }
}


