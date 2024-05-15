<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    const VALIDATION_RULES = [
        'last_name' => 'required',
        'first_name' => 'required',
        'patronymic' => 'required',
        'phone' => 'required|regex:/^[0-9()+\- ]+$/',
        'birth_date' => 'required|date:Y-m-d',
        'education' => 'required',
        'add_education' => 'nullable',
        'experience' => 'required|integer',
        'role' => 'nullable',
        'username' => 'nullable',
        'email' => 'nullable|email',
        'password' => 'nullable',
        'ban' => 'nullable',
    ];

    public function index(Request $request)
    {
        $role = $request->get('role');
        if (strlen($role) && in_array($role, Employee::ROLES)) {
            $employees = Employee::query()->where('role', '=', $role)->get();
        } else {
            $employees = Employee::query()->get();
        }

        return view('employee.index', [
            'employees' => $employees,
            'roles' => Employee::ROLES,
        ]);
    }


    public function show(string $id)
    {
        return view('employee.view', [
            'employee' => Employee::query()->findOrFail($id)
        ]);
    }

    public function add()
    {
        return view('employee.edit', [
            'employee' => new Employee(),
            'roles' => Employee::ROLES,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(self::VALIDATION_RULES);

        /** @var Employee $employee */
        $employee = Employee::query()->create($validated);

        // Учётная запись сотрудника
        if (strlen($request->get('username')) && strlen($request->get('email')) && strlen($request->get('password'))) {
            /** @var User $user */
            $user = User::query()->create([
                'name' => $request->get('username'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                'banned_at' => $request->get('ban') ? new Carbon() : null,
            ]);

            $employee->user_id = $user->id;
            $employee->save();
        }

        return redirect()->route('employee');
    }

    public function edit(string $id)
    {
        return view('employee.edit', [
            'employee' => Employee::query()->findOrFail($id),
            'roles' => Employee::ROLES,
        ]);
    }

    public function update(Request $request, string $id)
    {
        /** @var Employee $employee */
        $employee = Employee::query()->findOrFail($id);
        $validated = $request->validate(self::VALIDATION_RULES);
        $employee->update($validated);

        // Учётная запись сотрудника
        if (strlen($request->get('username')) || strlen($request->get('email')) || strlen($request->get('password'))) {
            $userNewProperties = [
                'name' => $request->get('username'),
                'email' => $request->get('email'),
                'banned_at' => $request->get('ban') ? new Carbon() : null,
            ];

            if (strlen($request->get('password'))) {
                $userNewProperties['password'] = bcrypt($request->get('password'));
            }

            /** @var User $user */
            if (null !== $employee->user) {
                $user = $employee->user;
                $user->update($userNewProperties);
            } else {
                $user = User::query()->create($userNewProperties);
                $employee->user_id = $user->id;
                $employee->save();
            }
        }

        return redirect()->route('employee');
    }

    public function delete(string $id)
    {
        /** @var Employee $employee */
        $employee = Employee::query()->findOrFail($id);
        $employee->delete();

        return redirect()->route('employee');
    }
}
