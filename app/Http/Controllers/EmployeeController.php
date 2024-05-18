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
        'username' => 'nullable',
        'email' => 'nullable|email',
        'password' => 'nullable',
        'role_id' => 'nullable',
        'ban' => 'nullable|boolean',
    ];

    public function index(Request $request)
    {
        $roleId = $request->get('role');
        if (strlen($roleId) && in_array($roleId, array_keys(User::ROLES))) {
            $employees = Employee::query()->whereHas('user', function ($query) use ($roleId) {
                return $query->where('role_id', '=', $roleId);
            })->get();
        } else {
            $employees = Employee::query()->get();
        }

        return view('employee.index', [
            'employees' => $employees,
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
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(self::VALIDATION_RULES);

        /** @var Employee $employee */
        $employee = Employee::query()->create($validated);

        // Учётная запись сотрудника
        if (strlen($request->get('username')) && strlen($request->get('password'))) {

            /** @var User $user */
            $user = User::query()->create([
                'name' => $request->get('username'),
                'email' => $request->get('email'),
                'role_id' => $request->get('role_id'),
                'password' => bcrypt($request->get('password')),
            ]);

            $employee->user_id = $user->id;
            $employee->save();

            $isBanned = filter_var($request->get('ban', false), FILTER_VALIDATE_BOOL);
            if ($isBanned) {
                $user->delete();
            }
        }

        return redirect()->route('employee');
    }

    public function edit(string $id)
    {
        return view('employee.edit', [
            'employee' => Employee::query()->findOrFail($id),
        ]);
    }

    public function update(Request $request, string $id)
    {
        /** @var Employee $employee */
        $employee = Employee::query()->findOrFail($id);
        $validated = $request->validate(self::VALIDATION_RULES);
        $employee->update($validated);


        // Учётная запись сотрудника
        if (null !== $employee->user || strlen($request->get('username'))) {

            $userData = [
                'name' => $request->get('username'),
                'email' => $request->get('email'),
                'role_id' => $request->get('role_id'),
            ];

            if (strlen($request->get('password'))) {
                $userData['password'] = bcrypt($request->get('password'));
            }

            /** @var User $user */
            if (null !== $employee->user) {
                $user = $employee->user;
                $user->update($userData);
            } else {
                $user = User::query()->create($userData);
                $employee->update(['user_id' => $user->id]);
            }

            $isBanned = filter_var($request->get('ban', false), FILTER_VALIDATE_BOOL);
            if ($isBanned) {
                $user->delete();
            } else {
                $user->restore();
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
