<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Role as SpatieRole;

/*
 * Class Role
 * @package App\Models
 *
 * @property string $uuid
 * @property string $name
 *
 * @property Permission[]|Collection $permissions
 */
class Role extends SpatieRole
{
    use HasFactory;
    use HasUuids;

    public const ROLE_ADMIN = 'Администратор';
    public const ROLE_MENTOR = 'Наставник';
    public const ROLE_EMPLOYEE = 'Сотрудник';
    public const ROLE_INTERN = 'Стажёр';

    public const ALL_ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_MENTOR,
        self::ROLE_EMPLOYEE,
        self::ROLE_INTERN,
    ];

    protected $primaryKey = 'uuid';
}
