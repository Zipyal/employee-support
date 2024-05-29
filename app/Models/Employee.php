<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;

/**
 * Class Employee
 * @package App\Models
 *
 * @property string $last_name
 * @property string $first_name
 * @property string $patronymic
 * @property string $gender
 * @property string $phone
 * @property string $email
 * @property Carbon $birth_date
 * @property string $education
 * @property string $add_education
 * @property int $experience
 * @property string $user_uuid
 * @property string $image_filepath
 *
 * @property Employee $mentor
 * @property EmploymentContract[]|Collection $contracts
 * @property Material[]|Collection $materials
 * @property Task[]|Collection $tasks
 * @property User $user
 * @property Briefing[]|Collection $briefingsRead
 * @property Briefing[]|Collection $briefingsUnread
 */
class Employee extends BaseModel
{
    use HasFactory;
    use HasUuids;

    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';

    public const GENDERS = [
        self::GENDER_MALE => 'М',
        self::GENDER_FEMALE => 'Ж',
    ];

    public const GENDERS_FULL = [
        self::GENDER_MALE => 'мужской',
        self::GENDER_FEMALE => 'женский',
    ];

    public $incrementing = false;
    protected $primaryKey = 'uuid';

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at',
    ];

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

    public function getShortNameAttribute(): string
    {
        $fullName = [];
        $fullName[] = $this->last_name;
        $fullName[] = mb_substr($this->first_name, 0, 1) . '.';
        if ($this->patronymic) {
            $fullName[] = mb_substr($this->patronymic, 0, 1) . '.';
        }
        return implode(' ', $fullName);
    }

    public function getLastFirstNameAttribute(): string
    {
        $fullName = [];
        $fullName[] = $this->last_name;
        $fullName[] = $this->first_name;
        return implode(' ', $fullName);
    }

    public function getFirstLastNameAttribute(): string
    {
        $fullName = [];
        $fullName[] = $this->first_name;
        $fullName[] = $this->last_name;
        return implode(' ', $fullName);
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'mentor_uuid', 'uuid');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(EmploymentContract::class)->orderBy('register_date', 'desc');
    }

    public function lastContract()
    {
        if ($this->contracts->isEmpty()) {
            return null;
        }

        return $this->contracts->first();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(material::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid')->withTrashed();
    }

    public function briefingsRead(): BelongsToMany
    {
        return $this->belongsToMany(Briefing::class)->withPivot('briefing_uuid');
    }

    public function isAllPublishedBriefingsRead(): bool
    {
        $briefingsRead = $this->briefingsRead->pluck('uuid')->toArray();
        $briefingsPublished = Briefing::published()->pluck('uuid')->toArray();

        return count(array_intersect($briefingsRead, $briefingsPublished)) == count($briefingsPublished);
    }
}
