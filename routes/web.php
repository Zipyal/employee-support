<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BriefingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmploymentContractController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\TestAnswerVariantController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestQuestionController;
use App\Http\Controllers\UploadImageController;
use App\Http\Controllers\UserController;
use App\Models\Permission;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::middleware('briefing')->group(function () {

        Route::get('/', [HomeController::class, 'index'])->name('home');

        Route::middleware(['canAny:' . implode(',', [
                Permission::BRIEFING_EDIT,
                Permission::BRIEFING_EDIT_OWN,
            ])])->group(function () {
            Route::delete('/upload-images/{id}/delete', [UploadImageController::class, 'delete'])->name('upload-image-delete');
        });

        Route::prefix('briefings')->group(function () {
            Route::get('/manage', [BriefingController::class, 'admin'])->name('briefing-manage')->middleware(['canAny:' . implode(',', [Permission::BRIEFING_EDIT, Permission::BRIEFING_DELETE, Permission::BRIEFING_SEE_ALL, Permission::BRIEFING_SEE_OWN])]);
            Route::get('/add', [BriefingController::class, 'add'])->name('briefing-add')->middleware(['can:' . Permission::BRIEFING_ADD]);
            Route::post('/add', [BriefingController::class, 'store'])->name('briefing-store')->middleware(['can:' . Permission::BRIEFING_ADD]);
            Route::get('/{id}/edit', [BriefingController::class, 'edit'])->name('briefing-edit')->middleware(['canAny:' . implode(',', [Permission::BRIEFING_EDIT, Permission::BRIEFING_EDIT_OWN])]);
            Route::post('/{id}/edit', [BriefingController::class, 'update'])->name('briefing-update')->middleware(['canAny:' . implode(',', [Permission::BRIEFING_EDIT, Permission::BRIEFING_EDIT_OWN])]);
            Route::post('/{id}/delete', [BriefingController::class, 'delete'])->name('briefing-delete')->middleware(['can:' . Permission::BRIEFING_DELETE]);
            Route::post('/{id}/publish', [BriefingController::class, 'publish'])->name('briefing-publish')->middleware(['can:' . Permission::BRIEFING_EDIT]);
            Route::post('/{id}/read', [BriefingController::class, 'read'])->name('briefing-read')->middleware(['canAny:' . implode(',', [Permission::BRIEFING_SEE_ALL, Permission::BRIEFING_SEE_PUBLISHED])]);
        });
        Route::middleware(['canAny:' . implode(',', [
                Permission::BRIEFING_SEE_ALL,
                Permission::BRIEFING_SEE_OWN,
                Permission::BRIEFING_SEE_PUBLISHED,
            ])])->group(function () {
            Route::get('/briefings', [BriefingController::class, 'index'])->name('briefing');
            Route::get('/briefings/{id}', [BriefingController::class, 'show'])->name('briefing-show');
        });


        Route::prefix('materials')->group(function () {
            Route::get('/manage', [MaterialController::class, 'admin'])->name('material-manage')->middleware(['canAny:' . implode(',', [Permission::MATERIAL_EDIT, Permission::MATERIAL_DELETE, Permission::MATERIAL_SEE_ALL, Permission::MATERIAL_SEE_OWN])]);
            Route::get('/add', [MaterialController::class, 'add'])->name('material-add')->middleware(['can:' . Permission::MATERIAL_ADD]);
            Route::post('/add', [MaterialController::class, 'store'])->name('material-store')->middleware(['can:' . Permission::MATERIAL_ADD]);
            Route::get('/{id}/edit', [MaterialController::class, 'edit'])->name('material-edit')->middleware(['can:' . Permission::MATERIAL_EDIT]);
            Route::post('/{id}/edit', [MaterialController::class, 'update'])->name('material-update')->middleware(['can:' . Permission::MATERIAL_EDIT]);
            Route::post('/{id}/delete', [MaterialController::class, 'delete'])->name('material-delete')->middleware(['can:' . Permission::MATERIAL_DELETE]);
            Route::post('/{id}/publish', [MaterialController::class, 'publish'])->name('material-publish')->middleware(['can:' . Permission::MATERIAL_EDIT]);
        });
        Route::middleware(['canAny:' . implode(',', [
                Permission::MATERIAL_SEE_ALL,
                Permission::MATERIAL_SEE_OWN,
                Permission::MATERIAL_SEE_PUBLISHED,
            ])])->group(function () {
            Route::get('/materials', [MaterialController::class, 'index'])->name('material');
            Route::get('/materials/{id}', [MaterialController::class, 'show'])->name('material-show');
        });


        Route::prefix('tests')->group(function () {
            Route::get('/manage', [TestController::class, 'admin'])->name('test-manage')->middleware(['canAny:' . implode(',', [Permission::TEST_EDIT, Permission::TEST_DELETE, Permission::TEST_SEE_ALL, Permission::TEST_SEE_OWN])]);
            Route::post('/questions/add', [TestQuestionController::class, 'store'])->name('test-add-question')->middleware(['canAny:' . implode(',', [Permission::TEST_ADD, Permission::TEST_EDIT])]);
            Route::post('/questions/{id}/delete', [TestQuestionController::class, 'delete'])->name('test-delete-question')->middleware(['can:' . Permission::TEST_EDIT]);
            Route::post('/answers/add', [TestAnswerVariantController::class, 'store'])->name('test-add-answer')->middleware(['canAny:' . implode(',', [Permission::TEST_ADD, Permission::TEST_EDIT])]);
            Route::post('/answers/{id}/edit', [TestAnswerVariantController::class, 'update'])->name('test-edit-answer')->middleware(['can:' . Permission::TEST_EDIT]);
            Route::post('/answers/{id}/delete', [TestAnswerVariantController::class, 'delete'])->name('test-delete-answer')->middleware(['can:' . Permission::TEST_EDIT]);
            Route::get('/add', [TestController::class, 'add'])->name('test-add')->middleware(['can:' . Permission::TEST_ADD]);
            Route::post('/add', [TestController::class, 'store'])->name('test-store')->middleware(['can:' . Permission::TEST_ADD]);
            Route::get('/{id}/edit', [TestController::class, 'edit'])->name('test-edit')->middleware(['can:' . Permission::TEST_EDIT]);
            Route::post('/{id}/edit', [TestController::class, 'update'])->name('test-update')->middleware(['can:' . Permission::TEST_EDIT]);
            Route::post('/{id}/delete', [TestController::class, 'delete'])->name('test-delete')->middleware(['can:' . Permission::TEST_DELETE]);
            Route::match(['get', 'post'], '/{id}/solve', [TestController::class, 'solve'])->name('test-solve')->middleware(['canAny:' . implode(',', [Permission::TEST_SEE_ALL, Permission::TEST_SEE_OWN, Permission::TEST_SEE_ASSIGNED])]);
        });
        Route::middleware(['canAny:' . implode(',', [
                Permission::TEST_SEE_ALL,
                Permission::TEST_SEE_OWN,
                Permission::TEST_SEE_ASSIGNED,
            ])])->group(function () {
            Route::get('/tests', [TestController::class, 'index'])->name('test');
            Route::get('/tests/{id}', [TestController::class, 'show'])->name('test-show');
        });


        Route::prefix('tasks')->group(function () {
            Route::get('/manage', [TaskController::class, 'admin'])->name('task-manage')->middleware(['canAny:' . implode(',', [Permission::TASK_EDIT, Permission::TASK_DELETE, Permission::TASK_SEE_ALL, Permission::TASK_SEE_OWN])]);
            Route::post('/comments/add', [TaskCommentController::class, 'store'])->name('task-add-comment')->middleware(['can:' . Permission::TASK_COMMENT]);
            Route::get('/add', [TaskController::class, 'add'])->name('task-add')->middleware(['can:' . Permission::TASK_ADD]);
            Route::post('/add', [TaskController::class, 'store'])->name('task-store')->middleware(['can:' . Permission::TASK_ADD]);
            Route::get('/{id}/edit', [TaskController::class, 'edit'])->name('task-edit')->middleware(['canAny:' . implode(',', [Permission::TASK_EDIT, Permission::TASK_EDIT_OWN])]);
            Route::post('/{id}/edit', [TaskController::class, 'update'])->name('task-update')->middleware(['canAny:' . implode(',', [Permission::TASK_EDIT, Permission::TASK_EDIT_OWN])]);
            Route::post('/{id}/delete', [TaskController::class, 'delete'])->name('task-delete')->middleware(['can:' . Permission::TASK_DELETE]);
            Route::post('/{id}/update-status', [TaskController::class, 'updateStatus'])->name('task-update-status')->middleware(['canAny:' . implode(',', [Permission::TASK_EDIT, Permission::TASK_EDIT_OWN, Permission::TASK_ASSIGNED_UPDATE_STATUS])]);
            Route::post('/{id}/update-assignee', [TaskController::class, 'updateAssignee'])->name('task-update-assignee')->middleware(['can:' . implode(',', [Permission::TASK_EDIT, Permission::TASK_EDIT_OWN, Permission::TASK_ASSIGNED_UPDATE_ASSIGNEE])]);
        });
        Route::middleware(['canAny:' . implode(',', [
                Permission::TASK_SEE_ALL,
                Permission::TASK_SEE_OWN,
                Permission::TASK_SEE_ASSIGNED,
            ])])->group(function () {
            Route::get('/tasks', [TaskController::class, 'index'])->name('task');
            Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('task-show');
        });


        Route::prefix('employees')->group(function () {
            Route::get('/manage', [EmployeeController::class, 'admin'])->name('employee-manage')->middleware(['canAny:' . implode(',', [Permission::EMPLOYEE_EDIT, Permission::EMPLOYEE_DELETE, Permission::EMPLOYEE_SEE_ALL])]);
            Route::get('/add', [EmployeeController::class, 'add'])->name('employee-add')->middleware(['can:' . Permission::EMPLOYEE_ADD]);
            Route::post('/add', [EmployeeController::class, 'store'])->name('employee-store')->middleware(['can:' . Permission::EMPLOYEE_ADD]);
            Route::delete('/{id}/image-delete', [EmployeeController::class, 'imageDelete'])->name('employee-image-delete');
            Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('employee-edit')->middleware(['can:' . Permission::EMPLOYEE_EDIT]);
            Route::post('/{id}/edit', [EmployeeController::class, 'update'])->name('employee-update')->middleware(['can:' . Permission::EMPLOYEE_EDIT]);
            Route::post('/{id}/delete', [EmployeeController::class, 'delete'])->name('employee-delete')->middleware(['can:' . Permission::EMPLOYEE_DELETE]);

            Route::get('/{employeeId}/contracts/add', [EmploymentContractController::class, 'add'])->name('employee-add-contract')->middleware(['can:' . Permission::EMPLOYEE_EDIT]);
            Route::post('/{employeeId}/contracts/add', [EmploymentContractController::class, 'store'])->name('employee-store-contract')->middleware(['can:' . Permission::EMPLOYEE_EDIT]);
            Route::get('/contracts/{contractId}/edit', [EmploymentContractController::class, 'edit'])->name('employee-edit-contract')->middleware(['can:' . Permission::EMPLOYEE_EDIT]);
            Route::post('/contracts/{contractId}/edit', [EmploymentContractController::class, 'update'])->name('employee-update-contract')->middleware(['can:' . Permission::EMPLOYEE_EDIT]);
            Route::post('/contracts/{contractId}/delete', [EmploymentContractController::class, 'delete'])->name('employee-delete-contract')->middleware(['can:' . Permission::EMPLOYEE_EDIT]);
        });
        Route::middleware(['canAny:' . implode(',', [
                Permission::EMPLOYEE_SEE_ALL,
                Permission::EMPLOYEE_SEE_OWN_INTERNS,
            ])])->group(function () {
            Route::get('/employees', [EmployeeController::class, 'index'])->name('employee');
            Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employee-show');
        });


        Route::prefix('roles')->group(function () {
            Route::get('/manage', [RoleController::class, 'admin'])->name('role-manage')->middleware(['canAny:' . implode(',', [Permission::ROLE_ADD, Permission::ROLE_EDIT, Permission::ROLE_DELETE, Permission::ROLE_SEE_ALL])]);
            Route::get('/add', [RoleController::class, 'add'])->name('role-add')->middleware(['can:' . Permission::ROLE_ADD]);
            Route::post('/add', [RoleController::class, 'store'])->name('role-store')->middleware(['can:' . Permission::ROLE_ADD]);
            Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('role-edit')->middleware(['can:' . Permission::ROLE_EDIT]);
            Route::post('/{id}/edit', [RoleController::class, 'update'])->name('role-update')->middleware(['can:' . Permission::ROLE_EDIT]);
            Route::post('/{id}/delete', [RoleController::class, 'delete'])->name('role-delete')->middleware(['can:' . Permission::ROLE_DELETE]);
        });

        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::get('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
