<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Briefing
 * @package App\Models
 *
 * @property string $subject
 * @property string $text
 * @property bool $published
 * @property int $author_uuid
 *
 * @property User $author
 * @property Task[]|Collection $tasks
 * @property Employee[]|Collection $employeesRead
 */
class Briefing extends BaseModel
{
    use HasFactory;
    use HasUuids;
    use HasUploadImageTrait;

    public $incrementing = false;
    protected $primaryKey = 'uuid';

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_uuid', 'uuid');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function employeesRead(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class)->withPivot('employee_uuid');
    }

    /**
     * @return Briefing[]|Collection
     */
    public static function published()
    {
        return self::query()->where('published', '=', true)->get();
    }

    public function isReadByEmployee($employeeId): bool
    {
        return in_array($employeeId, $this->employeesRead->pluck('uuid')->toArray());
    }
}
