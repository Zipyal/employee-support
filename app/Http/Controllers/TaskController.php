<?php

namespace App\Http\Controllers;

use App\Models\Briefing;
use App\Models\Employee;
use App\Models\Material;
use App\Models\Task;
use App\Models\Test;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    const VALIDATION_RULES = [
        'subject' => 'required',
        'status' => 'required',
        'type' => 'required',
        'start_date' => 'required|date:Y-m-d',
        'end_date' => 'nullable|date:Y-m-d',
        'description' => 'required',
        'author_uuid' => 'nullable',
        'employee_uuid' => 'nullable',
        'briefing_uuid' => 'nullable',
        'test_uuid' => 'nullable',
        'material_uuid' => 'nullable',
    ];

    public function index(Request $request)
    {
        $tasks = Task::query();

        $subject = $request->get('subject');
        if (strlen($subject)) {
            $tasks = $tasks->where('subject', 'like', '%' . $subject . '%');
        }

        $status = $request->get('status');
        if (strlen($status) && in_array($status, Task::STATUSES)) {
            $tasks = $tasks->where('status', '=', $status);
        }

        $type = $request->get('type');
        if (strlen($type) && in_array($type, Task::TYPES)) {
            $tasks = $tasks->where('type', '=', $type);
        }

        $employees = Employee::query()->get()->pluck('fullName', 'uuid')->toArray();
        $employeeUuid = $request->get('employee');
        if (strlen($employeeUuid) && in_array($employeeUuid, array_keys($employees))) {
            $tasks = $tasks->where('employee_uuid', '=', $employeeUuid);
        }

        return view('task.index', [
            'tasks' => $tasks->get(),
            'statuses' => Task::STATUSES,
            'types' => Task::TYPES,
            'employees' => $employees,
        ]);
    }


    public function show(string $id)
    {
        return view('task.view', [
            'task' => Task::query()->findOrFail($id),
            'statuses' => Task::STATUSES,
            'types' => Task::TYPES,
        ]);
    }

    public function add()
    {
        $task = new Task();
        $task->status = Task::STATUSES[0]; // статус по умолчанию

        return view('task.edit', [
            'task' => $task,
            'statuses' => Task::STATUSES,
            'types' => Task::TYPES,
            'employees' => Employee::query()->get()->pluck('fullName', 'uuid')->toArray(),
            'briefings' => Briefing::query()->get()->pluck('subject', 'uuid')->toArray(),
            'materials' => Material::query()->get()->pluck('subject', 'uuid')->toArray(),
            'tests' => Material::query()->get(['uuid', 'subject'])->pluck('subject', 'uuid')->toArray(),
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
            'statuses' => Task::STATUSES,
            'types' => Task::TYPES,
            'employees' => Employee::query()->get()->pluck('fullName', 'uuid')->toArray(),
            'briefings' => Briefing::query()->get()->pluck('subject', 'uuid')->toArray(),
            'materials' => Material::query()->get()->pluck('subject', 'uuid')->toArray(),
            'tests' => Test::query()->get(['uuid', 'subject'])->pluck('subject', 'uuid')->toArray(),
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

    public function delete(string $id)
    {
        /** @var Task $task */
        $task = Task::query()->findOrFail($id);
        $task->delete();

        return redirect()->route('task');
    }
}


