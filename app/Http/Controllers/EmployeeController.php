<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    const VALIDATION_RULES = [
        'last_name' => 'required',
        'first_name' => 'required',
        'patronymic' => 'required',
        'phone' => 'required|regex:/^[0-9 -()+]+$/',
        'role' => 'required',
        'email' => 'required|email',
        'position' => 'required',
        'department' => 'required',
        'education' => 'required',
        'experience' => 'required|integer',
    ];

    public function index()
    {
        return view('employee.index', [
            'employees' => Employee::query()->get()
        ]);
    }

    public function show(string $id)
    {
        return view('employees.view', [
            'employee' => Employee::query()->findOrFail($id)
        ]);
    }

    public function add()
    {
        return view('employees.edit', [
            'employee' => new Employee(),
            'roles' => Employee::ROLES,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(self::VALIDATION_RULES);


        Employee::query()->create($validated);

        return redirect('/employees');
    }

    public function edit(string $id)
    {
        return view('employees.edit', [
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
        return redirect('/employees');
    }

    public function delete($id)
    {
        /** @var Employee $employee */
        $employee = Employee::query()->findOrFail($id);
        $employee->delete();
        return redirect('/employees');
    }
}


