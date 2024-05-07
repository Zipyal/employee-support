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
        'birth_date' => 'required|date',
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


        Employee::query()->create($validated);

        return redirect()->route('/employee');
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
        return redirect()->route('/employee');
    }

    public function delete($id)
    {
        /** @var Employee $employee */
        $employee = Employee::query()->findOrFail($id);
        $employee->delete();
        return redirect()->route('/employee');
    }
}


