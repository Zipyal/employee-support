<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (Permission::allPermissions() as $permission) {
            Permission::create(['name' => $permission]);
        }

        foreach (Role::ALL_ROLES as $roleName) {
            /** @var Role $role */
            $role = Role::query()->firstOrCreate(['name' => $roleName]);

            switch ($roleName) {
                case Role::ROLE_ADMIN:
                    $role->syncPermissions(Permission::allPermissions());
                    break;

                case Role::ROLE_MENTOR:
                    $role->syncPermissions([
                        Permission::MATERIAL_SEE_ALL,
                        Permission::MATERIAL_ADD,
                        Permission::MATERIAL_DELETE,
                        Permission::MATERIAL_EDIT,

                        Permission::BRIEFING_SEE_ALL,
                        Permission::BRIEFING_ADD,
                        Permission::BRIEFING_DELETE,
                        Permission::BRIEFING_EDIT,

                        Permission::TEST_SEE_ALL,
                        Permission::TEST_ADD,
                        Permission::TEST_DELETE,
                        Permission::TEST_EDIT,

                        Permission::TASK_SEE_ALL,
                        Permission::TASK_ADD,
                        Permission::TASK_DELETE,
                        Permission::TASK_EDIT,
                        Permission::TASK_COMMENT,

                        Permission::EMPLOYEE_SEE_OWN_INTERNS,
                    ]);
                    break;

                case Role::ROLE_EMPLOYEE:
                    $role->syncPermissions([
                        Permission::MATERIAL_SEE_PUBLISHED,
                        Permission::BRIEFING_SEE_PUBLISHED,
                        Permission::TEST_SEE_ASSIGNED,
                        Permission::TASK_ADD,
                        Permission::TASK_EDIT_OWN,
                        Permission::TASK_ASSIGNED_UPDATE_STATUS,
                        Permission::TASK_ASSIGNED_UPDATE_ASSIGNEE,
                        Permission::TASK_SEE_ASSIGNED,
                        Permission::TASK_COMMENT,
                    ]);
                    break;

                case Role::ROLE_INTERN:
                    $role->syncPermissions([
                        Permission::MATERIAL_SEE_PUBLISHED,
                        Permission::BRIEFING_SEE_PUBLISHED,
                        Permission::TEST_SEE_ASSIGNED,
                        Permission::TASK_SEE_ASSIGNED,
                        Permission::TASK_ASSIGNED_UPDATE_STATUS,
                        Permission::TASK_ASSIGNED_UPDATE_ASSIGNEE,
                        Permission::TASK_COMMENT,
                    ]);
                    break;
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::query()->whereIn('name', Permission::allPermissions())->delete();
        Role::query()->whereIn('name', Role::ALL_ROLES)->delete();
    }
};
