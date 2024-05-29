<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmploymentContract;
use Illuminate\Http\Request;

class EmploymentContractController extends Controller
{
    const VALIDATION_RULES = [
        'number' => 'required',
        'register_date' => 'required|date:Y-m-d',
        'end_date' => 'nullable|date:Y-m-d',
        'register_address' => 'required',
        'employee_uuid' => 'required',
        'position' => 'required',
        'department' => 'required',
        'salary' => 'required|numeric',
        'rate' => 'required|integer|between:1,24',
    ];

    public function add($employeeId)
    {
        $employee = Employee::query()->findOrFail($employeeId);

        return view('employmentContract.edit', [
            'employee' => $employee,
            'employmentContract' => new EmploymentContract(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(self::VALIDATION_RULES);
        EmploymentContract::query()->create($validated);

        return redirect()->route('employee-show', ['id' => $validated['employee_uuid']]);
    }

    public function edit(string $id)
    {
        /** @var EmploymentContract $employmentContract */
        $employmentContract = EmploymentContract::query()->findOrFail($id);

        return view('employmentContract.edit', [
            'employmentContract' => $employmentContract,
            'employee' => $employmentContract->employee,
        ]);
    }

    public function update(Request $request, string $id)
    {
        /** @var EmploymentContract $employmentContract */
        $employmentContract = EmploymentContract::query()->findOrFail($id);
        $employee = $employmentContract->employee;
        $validated = $request->validate(self::VALIDATION_RULES);
        $employmentContract->update($validated);

        return redirect()->route('employee-show', ['id' => $employee->uuid]);
    }

    public function delete(string $id)
    {
        /** @var EmploymentContract $employmentContract */
        $employmentContract = EmploymentContract::query()->findOrFail($id);
        $employee = $employmentContract->employee;
        $employmentContract->delete();

        return redirect()->route('employee-show', ['id' => $employee->uuid]);
    }
}
