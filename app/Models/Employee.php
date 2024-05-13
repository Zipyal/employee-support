<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Employee
 * @package App\Models
 *
 * @property string $last_name
 * @property string $first_name
 * @property string $patronymic
 * @property string $phone
 * @property string $email
 * @property string $position
 * @property string $department
 * @property Carbon $birth_date
 * @property string $education
 * @property string $add_education
 * @property string $experience
 * @property string $role
 *
 * @property Employee $mentor
 * @property EmploymentContract[]|Collection $contracts
 * @property Material[]|Collection $materials
 * @property Task[]|Collection $tasks
 */
class Employee extends Model
{
    use HasFactory;
    use HasUuids;

    public const ROLES = [
        'Сотрудник',
        'Наставник',
        'Администратор',
    ];

    public $incrementing = false;
    protected $primaryKey = 'uuid';

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at',
    ];


    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'mentor_uuid', 'uuid');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(EmploymentContract::class)->orderBy('register_date', 'desc');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(material::class);
    }

    public function getFullNameAttribute(): string
    {
        $fullName = [];
        $fullName[] = $this->last_name;
        $fullName[] = $this->first_name;
        if ($this->patronymic) {
            $fullName[] = $this->patronymic;
        }
        return implode(' ', $fullName);
    }

    public function lastContract()
    {
        if ($this->contracts->isEmpty()) {
            return null;
        }

        return $this->contracts->first();
    }
}
