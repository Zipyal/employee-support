<?php

namespace App\Http\Controllers;

use App\Models\Briefing;
use App\Models\Employee;
use App\Models\Material;
use App\Models\Permission;
use App\Models\Task;
use App\Models\Test;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class TaskController extends Controller
{
    const VALIDATION_RULES = [
        'subject' => 'required',
        'status' => 'required',
        'priority' => 'required',
        'type' => 'required',
        'start_date' => 'required|date:Y-m-d',
        'end_date' => 'nullable|date:Y-m-d',
        'description' => 'required',
        'author_id' => 'nullable',
        'employee_uuid' => 'nullable',
        'briefing_uuid' => 'nullable',
        'test_uuid' => 'nullable',
        'material_uuid' => 'nullable',
    ];

    protected string $imagesDir = 'img/upload/tasks';

    public function index(Request $request)
    {
        if (!isset(auth()->user()->employee)) {
            return view('task.index', [
                'tasks' => Collection::empty(),
                'statuses' => Task::STATUSES,
                'priorities' => Task::PRIORITIES,
                'types' => Task::TYPES,
            ]);
        }

        $tasks = Task::query()->where('employee_uuid', '=', auth()->user()->employee->uuid);

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

        return view('task.index', [
            'tasks' => $tasks->get(),
            'statuses' => Task::STATUSES,
            'priorities' => Task::PRIORITIES,
            'types' => Task::TYPES,
        ]);
    }

    public function show(string $id)
    {
        /** @var Task $task */
        $task = Task::query()->findOrFail($id);

        /** @var User $currentUser */
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        if (!$currentUser->can(Permission::TASK_SEE_ALL) && $currentUser->can(Permission::TASK_SEE_OWN) && !$currentUser->can(Permission::TASK_SEE_ASSIGNED)) {
            if (!$task->author_uuid || $task->author_uuid !== $currentUser->uuid) {
                abort(403);
            }
        }

        if (!$currentUser->can(Permission::TASK_SEE_ALL) && !$currentUser->can(Permission::TASK_SEE_OWN) && $currentUser->can(Permission::TASK_SEE_ASSIGNED)) {
            if (!$currentEmployee instanceof Employee) {
                abort(403);
            }
            if (!$task->employee_uuid || $task->employee_uuid !== $currentEmployee->uuid) {
                abort(403);
            }
        }

        // if (!$currentUser->hasPermissionTo(Permission::TASK_SEE_ALL)) {
        //     if (
        //         $currentUser->hasPermissionTo(Permission::TASK_SEE_ASSIGNED)
        //         && !in_array($currentUser?->role_id, [User::ROLE_ADMIN, User::ROLE_MENTOR])
        //         && $task->employee_uuid != auth()->user()?->employee?->uuid
        //     ) {
        //         return abort(403);
        //     }
        // }

        return view('task.view', [
            'task' => Task::query()->findOrFail($id),
            'statuses' => Task::STATUSES,
            'priorities' => Task::PRIORITIES,
            'types' => Task::TYPES,
        ]);
    }

    public function admin(Request $request)
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

        return view('task.admin', [
            'tasks' => $tasks->get(),
            'statuses' => Task::STATUSES,
            'priorities' => Task::PRIORITIES,
            'types' => Task::TYPES,
            'employees' => $employees,
        ]);
    }

    public function add()
    {
        $task = new Task();
        $task->status = Task::STATUSES[0]; // статус по умолчанию
        $task->priority = Task::PRIORITY_NORMAL; // приоритет по умолчанию

        return view('task.edit', [
            'task' => $task,
            'statuses' => Task::STATUSES,
            'priorities' => Task::PRIORITIES,
            'types' => Task::TYPES,
            'employees' => Employee::query()->with('user')->get()->sortBy('user.role_id'),
            'briefings' => Briefing::query()->get(['uuid', 'subject'])->pluck('subject', 'uuid')->toArray(),
            'materials' => Material::query()->get(['uuid', 'subject'])->pluck('subject', 'uuid')->toArray(),
            'tests' => Test::query()->get(['uuid', 'subject'])->pluck('subject', 'uuid')->toArray(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(self::VALIDATION_RULES);

        /** @var Task $task */
        $task = Task::query()->create($validated);

        $currentUser = auth()->user();
        Task::withoutTimestamps(function () use (&$task, $currentUser) {
            $task->author_uuid = $currentUser->uuid;
            $task->save();
        });

        $this->uploadImages($request, Task::class, $task->id);

        if ($request->get('stay-here')) {
            return redirect()->route('task-edit', ['id' => $task->id]);
        } else {
            return redirect()->route('task-manage');
        }
    }

    public function edit(string $id)
    {
        /** @var Task $task */
        $task = Task::query()->findOrFail($id);

        /** @var User $currentUser */
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        if ($currentUser->cannot(Permission::TASK_EDIT) && $currentUser->can(Permission::TASK_EDIT_OWN)) {
            if (!$currentEmployee instanceof Employee) {
                abort(403);
            }

            if (!$task->author_uuid || $task->author_uuid !== $currentUser->uuid) {
                abort(403);
            }
        }

        return view('task.edit', [
            'task' => $task,
            'statuses' => Task::STATUSES,
            'priorities' => Task::PRIORITIES,
            'types' => Task::TYPES,
            'employees' => Employee::query()->with('user')->get()->sortBy('user.role_id'),
            'briefings' => Briefing::query()->get()->pluck('subject', 'uuid')->toArray(),
            'materials' => Material::query()->get()->pluck('subject', 'uuid')->toArray(),
            'tests' => Test::query()->get(['uuid', 'subject'])->pluck('subject', 'uuid')->toArray(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        /** @var Task $task */
        $task = Task::query()->findOrFail($id);

        /** @var User $currentUser */
        $currentUser = auth()->user();
        $currentEmployee = $currentUser->employee;

        if ($currentUser->cannot(Permission::TASK_EDIT) && $currentUser->can(Permission::TASK_EDIT_OWN)) {
            if (!$currentEmployee instanceof Employee) {
                abort(403);
            }

            if (!$task->author_uuid || $task->author_uuid !== $currentUser->uuid) {
                abort(403);
            }
        }

        $validated = $request->validate(self::VALIDATION_RULES);
        $task->update($validated);

        $this->uploadImages($request, Task::class, $task->id);

        if ($request->get('stay-here')) {
            return redirect()->back();
        } else {
            return redirect()->route('task-manage');
        }
    }

    public function updateStatus(Request $request, string $id)
    {
        if (!strlen($request->get('status'))) {
            return abort(400, 'Не передан новый статус!');
        }

        if (!in_array($request->get('status'), Task::STATUSES)) {
            return abort(400, 'Передан некорректный новый статус!');
        }

        try {
            /** @var Task $task */
            $task = Task::query()->findOrFail($id);
            $task->updateOrFail(['status' => $request->get('status')]);
            $responseData = [
                'uuid' => $task->id,
                'status' => $task->status,
                'updated_at' => $task->updated_at->format('Y-m-d H:i:s'),
            ];
        } catch (\Throwable $e) {
            return abort(500, $e->getMessage());
        }

        return response()->json($responseData);
    }

    public function updateAssignee(Request $request, string $id)
    {
        if (!strlen($request->get('employee_uuid'))) {
            return abort(400, 'Не передан сотрудник на кого назначить задачу!');
        }

        try {
            /** @var Task $task */
            $task = Task::query()->findOrFail($id);
            $task->updateOrFail(['employee_uuid' => $request->get('employee_uuid')]);
            $responseData = [
                'uuid' => $task->id,
                'employee' => $task->employee,
                'updated_at' => $task->updated_at->format('Y-m-d H:i:s'),
            ];
        } catch (\Throwable $e) {
            return abort(500, $e->getMessage());
        }

        return response()->json($responseData);
    }

    public function delete(string $id)
    {
        /** @var Task $task */
        $task = Task::query()->findOrFail($id);
        $task->delete();

        if (in_array(url()->previous(), [route('task-manage'), route('task')])) {
            return redirect()->back();
        }

        return redirect()->route('task-manage');
    }
}


