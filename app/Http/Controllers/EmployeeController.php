<?php

namespace App\Http\Controllers;

use App\Models\Briefing;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\Role;
use App\Models\UploadImage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EmployeeController extends Controller
{
    const VALIDATION_RULES = [
        'last_name' => 'required',
        'first_name' => 'required',
        'patronymic' => 'required',
        'gender' => 'required|in:' . Employee::GENDER_MALE . ',' . Employee::GENDER_FEMALE,
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
        'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
    ];

    protected string $imagesDir = 'img/upload/employees';

    public function index(Request $request)
    {
        $employees = Employee::query();

        /** @var User $currentUser */
        $currentUser = auth()->user();

        if ($currentUser->cannot(Permission::EMPLOYEE_SEE_ALL) && $currentUser->can(Permission::EMPLOYEE_SEE_OWN_INTERNS)) {
            if (!$currentUser->employee instanceof Employee) {
                abort(403);
            }

            $employees = $employees->where('mentor_uuid', '=', $currentUser->employee->uuid);
        }

        return view('employee.index', [
            'employees' => $employees->get(),
        ]);
    }


    public function show(string $id)
    {
        /** @var Employee $employee */
        $employee = Employee::query()->findOrFail($id);

        /** @var User $currentUser */
        $currentUser = auth()->user();
        if ($currentUser->cannot(Permission::EMPLOYEE_SEE_ALL) && $currentUser->can(Permission::EMPLOYEE_SEE_OWN_INTERNS)) {
            if (!$currentUser->employee instanceof Employee || $employee->mentor_uuid !== $currentUser->employee->uuid) {
                abort(403);
            }
        }

        return view('employee.view', [
            'employee' => $employee
        ]);
    }

    public function admin(Request $request)
    {
        $roleName = $request->get('role');
        if (strlen($roleName)) {
            $usersByRole = User::withTrashed()->with('roles')->get()->filter(
                function ($user) use ($roleName) {
                    return $user->roles->where('name', $roleName)->toArray();
                }
            );
            $employees = Employee::query()->whereIn('user_uuid', $usersByRole->pluck('uuid'))->get();
        } else {
            $employees = Employee::query()->get();
        }

        return view('employee.admin', [
            'employees' => $employees,
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

            $employee->user_uuid = $user->id;
            $employee->save();

            $this->uploadImage($request, $employee);

            $isBanned = filter_var($request->get('ban', false), FILTER_VALIDATE_BOOL);
            if ($isBanned) {
                $user->delete();
            }
        }

        if ($request->get('stay-here')) {
            return redirect()->route('employee-edit', ['id' => $employee->uuid]);
        } else {
            return redirect()->route('employee-manage');
        }
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

        $this->uploadImage($request, $employee);

        // Учётная запись сотрудника
        if (null !== $employee->user || strlen($request->get('username'))) {

            $userData = [
                'name' => $request->get('username'),
                'email' => $request->get('email'),
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
                $employee->update(['user_uuid' => $user->uuid]);
            }

            $isBanned = filter_var($request->get('ban', false), FILTER_VALIDATE_BOOL);
            if ($isBanned) {
                $user->delete();
            } else {
                $user->restore();
            }

            if ($request->get('role')) {
                $user->syncRoles($request->get('role'));
            } else {
                $user->syncRoles([]);
            }
        }

        if ($request->get('stay-here')) {
            return redirect()->route('employee-edit', ['id' => $employee->uuid]);
        } else {
            return redirect()->route('employee-manage');
        }
    }

    public function delete(string $id)
    {
        /** @var Employee $employee */
        $employee = Employee::query()->findOrFail($id);
        $employee->delete();

        if (in_array(url()->previous(), [route('employee-manage'), route('employee')])) {
            return redirect()->back();
        }

        return redirect()->route('employee-manage');
    }

    /**
     * @param Request $request
     * @param string $modelClass
     * @param string|int $modelId
     * @return void
     */
    protected function uploadImage(Request $request, Employee &$model): void
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $filename = $file->getClientOriginalName();
            $filename = preg_replace('/\s+/', '_', trim($filename));

            $dir = $this->imagesDir;
            $dirAbsolute = public_path($dir);
            $filepath = rtrim($dir, '/') . '/' . $filename;

            try {
                $file->move($dirAbsolute, $filename);
            } catch (\Throwable $e) {
                abort($e->getCode(), $e->getMessage());
            }

            $oldImageFilepath = $model->image_filepath;

            Employee::withoutTimestamps(function () use (&$model, $filepath, $oldImageFilepath) {
                $model->image_filepath = $filepath;
                if ($model->save()) {
                    if (strlen($oldImageFilepath)) {
                        File::delete($oldImageFilepath);
                    }
                }
            });
        }
    }

    public function imageDelete(string $id)
    {
        /** @var User $currentUser */
        $currentUser = auth()->user();

        /** @var Employee $model */
        $model = Employee::query()->findOrFail($id);

        if (!$currentUser->can(Permission::EMPLOYEE_EDIT)) {
            abort(403);
        }

        try {
            File::delete($model->image_filepath);
            $model->image_filepath = null;
            $model->save();
        } catch (\Throwable $e) {
            abort($e->getCode(), $e->getMessage());
        }

        return response()->noContent();
    }
}
