<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Mentor
 * @package App\Models
 *
 * @property string $last_name
 * @property string $first_name
 * @property string $patronymic
 * @property string $phone
 * @property string $email
 * @property string $role
 * @property string $position
 * @property string $department
 * @property string $education
 * @property string $add_education
 * @property int $experience
 *
 * @property Material[]|Collection $materials
 * @property Employee[]|Collection $employees
 */
class Mentor extends Model
{
    use HasFactory;
    use HasUuids;

    public const ROLES = [
        'Сотрудник',
        'Наставник',
        'Администратор',
    ];

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at',
    ];

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
