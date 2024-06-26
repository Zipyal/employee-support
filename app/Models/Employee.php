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
 * @property string $birth_date
 * @property string $education
 * @property string $add_education
 * @property string $experience
 * @property string $role
 *
 * @property Mentor $mentor
 * @property EmploymentContract $employmentContract
 * @property Task[]|Collection $tasks
 */
class Employee extends Model
{
    use HasFactory;
    use HasUuids;


    protected $fillable = [
        'last_name',
        'first_name',
        'patronymic',
        'phone',
        'email',
        'birth_date',
        'education',
        'add_education',
        'experience',
        'role',
    ];

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Mentor::class, 'mentor_uuid', 'uuid');
    }

    public function employmentContract(): BelongsTo
    {
        return $this->belongsTo(EmploymentContract::class, 'employment_contract_uuid', 'uuid');
    }

    public function tasks(): HasMany
    {
        return $this->HasMany(Task::class);
    }
}
