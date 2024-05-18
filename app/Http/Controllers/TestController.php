<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    const VALIDATION_RULES = [
        'category' => 'required',
        'subject' => 'required',
    ];

    public function index(Request $request)
    {
        $tests = Test::query();

        $employees = Employee::query()->get()->pluck('fullName', 'uuid')->toArray();
        if (in_array(auth()->user()?->role_id, [User::ROLE_ADMIN, User::ROLE_MENTOR])) {
            $employeeUuid = $request->get('employee');
            if (strlen($employeeUuid) && in_array($employeeUuid, array_keys($employees))) {
                $tests = $tests->whereHas('tasks', function($query) use ($employeeUuid) {
                    return $query->where('employee_uuid', '=', $employeeUuid);
                });
            }
        } else {
            $tests = $tests->whereHas('tasks', function($query) {
                return $query->where('employee_uuid', '=', auth()->user()?->employee?->uuid);
            });
        }

        return view('test.index', [
            'tests' => $tests->get(),
        ]);
    }


    public function show(string $id)
    {
        return view('test.view', [
            'test' => Test::query()->findOrFail($id)
        ]);
    }

    public function add()
    {
        return view('test.edit', [
            'test' => new Test(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(self::VALIDATION_RULES);

        Test::query()->create($validated);

        return redirect()->route('test');
    }

    public function edit(string $id)
    {
        return view('test.edit', [
            'test' => Test::query()->findOrFail($id),
        ]);
    }

    public function update(Request $request, string $id)
    {
        /** @var Test $test */
        $test = Test::query()->findOrFail($id);
        $validated = $request->validate(self::VALIDATION_RULES);
        $test->update($validated);
        return redirect()->route('test');
    }

    public function delete($id)
    {
        /** @var Test $test */
        $test = Test::query()->findOrFail($id);
        $test->delete();
        return redirect()->route('test');
    }
}


