<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    const VALIDATION_RULES = [
        'name' => 'required',
    ];

    public function admin()
    {
        return view('role.admin', [
            'roles' => Role::query()->orderBy('created_at')->get(),
        ]);
    }

    public function add()
    {
        return view('role.edit', [
            'role' => new Role(),
            'rolePermissions' => Collection::empty(),
            'permissions' => Permission::query()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(self::VALIDATION_RULES);
        $role = Role::query()->create($validated);

        if (isset($request['permissions']) && count($request['permissions'])) {
            $role->permissions()->sync($request['permissions']);
        }

        return redirect()->route('role-manage');
    }

    public function edit(string $id)
    {
        /** @var Role $role */
        $role = Role::query()->findOrFail($id);

        $rolePermissions = $role->permissions;
        $otherPermissions = Permission::query()->whereNotIn('uuid', $rolePermissions->pluck('uuid')->toArray())->get();

        return view('role.edit', [
            'role' => $role,
            'rolePermissions' => $rolePermissions,
            'permissions' => $otherPermissions,
        ]);
    }

    public function update(Request $request, string $id)
    {
        /** @var Role $role */
        $role = Role::query()->findOrFail($id);
        $validated = $request->validate(self::VALIDATION_RULES);
        $role->update($validated);

        $role->permissions()->sync($request['permissions'] ?? []);
        $role->update(['updated_at' => Carbon::now()]);

        if ($request->get('stay-here')) {
            return redirect()->back();
        } else {
            return redirect()->route('role-manage');
        }
    }

    public function delete(string $id)
    {
        /** @var Role $role */
        $role = Role::query()->findOrFail($id);
        $role->delete();

        if (in_array(url()->previous(), [route('role-manage'), route('role')])) {
            return redirect()->back();
        }

        return redirect()->route('role-manage');
    }
}
