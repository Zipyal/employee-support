<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'uuid';


    public const FEED_SEE = 'Видеть ленту';

    public const COMMON_PERMISSIONS = [
        self::FEED_SEE
    ];


    public const MATERIAL_SEE_ALL = 'Видеть все материалы';
    public const MATERIAL_SEE_OWN = 'Видеть свои материалы';
    public const MATERIAL_SEE_PUBLISHED = 'Видеть опубликованные материалы';
    public const MATERIAL_ADD = 'Создавать материалы';
    public const MATERIAL_DELETE = 'Удалять материалы';
    public const MATERIAL_EDIT = 'Редактировать материалы';

    public const MATERIAL_PERMISSIONS = [
        self::MATERIAL_SEE_ALL,
        self::MATERIAL_SEE_OWN,
        self::MATERIAL_SEE_PUBLISHED,
        self::MATERIAL_ADD,
        self::MATERIAL_DELETE,
        self::MATERIAL_EDIT,
    ];


    public const BRIEFING_SEE_ALL = 'Видеть все инструктажи';
    public const BRIEFING_SEE_OWN = 'Видеть свои инструктажи';
    public const BRIEFING_SEE_PUBLISHED = 'Видеть опубликованные инструктажи';
    public const BRIEFING_ADD = 'Создавать инструктажи';
    public const BRIEFING_DELETE = 'Удалять инструктажи';
    public const BRIEFING_DELETE_OWN = 'Удалять свои инструктажи';
    public const BRIEFING_EDIT = 'Редактировать инструктажи';
    public const BRIEFING_EDIT_OWN = 'Редактировать свои инструктажи';

    public const BRIEFING_PERMISSIONS = [
        self::BRIEFING_SEE_ALL,
        self::BRIEFING_SEE_OWN,
        self::BRIEFING_SEE_PUBLISHED,
        self::BRIEFING_ADD,
        self::BRIEFING_DELETE,
        self::BRIEFING_DELETE_OWN,
        self::BRIEFING_EDIT,
        self::BRIEFING_EDIT_OWN,
    ];


    public const TEST_SEE_ALL = 'Видеть все тесты';
    public const TEST_SEE_ASSIGNED = 'Видеть назначенные тесты';
    public const TEST_SEE_OWN = 'Видеть свои тесты';
    public const TEST_ADD = 'Создавать тесты';
    public const TEST_DELETE = 'Удалять тесты';
    public const TEST_EDIT = 'Редактировать тесты';

    public const TEST_PERMISSIONS = [
        self::TEST_SEE_ALL,
        self::TEST_SEE_ASSIGNED,
        self::TEST_SEE_OWN,
        self::TEST_ADD,
        self::TEST_DELETE,
        self::TEST_EDIT,
    ];


    public const TASK_SEE_ALL = 'Видеть все задачи';
    public const TASK_SEE_ASSIGNED = 'Видеть назначенные задачи';
    public const TASK_SEE_OWN = 'Видеть свои задачи';
    public const TASK_ADD = 'Создавать задачи';
    public const TASK_DELETE = 'Удалять задачи';
    public const TASK_EDIT = 'Редактировать задачи';
    public const TASK_EDIT_OWN = 'Редактировать свои задачи';
    public const TASK_ASSIGNED_UPDATE_STATUS = 'Менять статус у назначенных задач';
    public const TASK_ASSIGNED_UPDATE_ASSIGNEE = 'Переводить на других назначенные задачи';
    public const TASK_COMMENT = 'Комментировать задачи';

    public const TASK_PERMISSIONS = [
        self::TASK_SEE_ALL,
        self::TASK_SEE_ASSIGNED,
        self::TASK_SEE_OWN,
        self::TASK_ADD,
        self::TASK_DELETE,
        self::TASK_EDIT,
        self::TASK_EDIT_OWN,
        self::TASK_ASSIGNED_UPDATE_STATUS,
        self::TASK_ASSIGNED_UPDATE_ASSIGNEE,
        self::TASK_COMMENT,
    ];


    public const EMPLOYEE_SEE_ALL = 'Видеть всех сотрудников';
    public const EMPLOYEE_SEE_OWN_INTERNS = 'Видеть своих сотрудников-стажёров';
    public const EMPLOYEE_ADD = 'Добавлять сотрудников';
    public const EMPLOYEE_DELETE = 'Удалять сотрудников';
    public const EMPLOYEE_EDIT = 'Редактировать сотрудников';

    public const EMPLOYEE_PERMISSIONS = [
        self::EMPLOYEE_SEE_ALL,
        self::EMPLOYEE_SEE_OWN_INTERNS,
        self::EMPLOYEE_ADD,
        self::EMPLOYEE_DELETE,
        self::EMPLOYEE_EDIT,
    ];


    public const ROLE_SEE_ALL = 'Видеть все роли';
    public const ROLE_SEE_OWN = 'Видеть свои роли';
    public const ROLE_ADD = 'Создавать роли';
    public const ROLE_DELETE = 'Удалять роли';
    public const ROLE_EDIT = 'Редактировать роли';

    public const ROLE_PERMISSIONS = [
        self::ROLE_SEE_ALL,
        self::ROLE_SEE_OWN,
        self::ROLE_ADD,
        self::ROLE_DELETE,
        self::ROLE_EDIT,
    ];


    public const GROUP_COMMON = 'Общее';
    public const GROUP_MATERIALS = 'Материалы';
    public const GROUP_BRIEFINGS = 'Инструктажи';
    public const GROUP_TESTS = 'Тесты';
    public const GROUP_TASKS = 'Задачи';
    public const GROUP_EMPLOYEES = 'Сотрудники';
    public const GROUP_ROLES = 'Роли';

    public const PERMISSIONS_GROUPED = [
        self::GROUP_COMMON => self::COMMON_PERMISSIONS,
        self::GROUP_MATERIALS => self::MATERIAL_PERMISSIONS,
        self::GROUP_BRIEFINGS => self::BRIEFING_PERMISSIONS,
        self::GROUP_TESTS => self::TEST_PERMISSIONS,
        self::GROUP_TASKS => self::TASK_PERMISSIONS,
        self::GROUP_EMPLOYEES => self::EMPLOYEE_PERMISSIONS,
        self::GROUP_ROLES => self::ROLE_PERMISSIONS,
    ];


    public static function allPermissions(): array
    {
        $allPermissions = [];

        foreach (self::PERMISSIONS_GROUPED as $permissions) {
            $allPermissions = array_merge($allPermissions, $permissions);
        }

        return $allPermissions;
    }
}
