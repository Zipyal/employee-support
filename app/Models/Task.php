<?php

namespace App\Models;

use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Task
 * @package App\Models
 *
 * @property string $subject
 * @property string $status
 * @property string $type
 * @property Date $start_date
 * @property Date $end_date
 * @property string $description
 * @property string $employee_uuid
 * @property string $test_uuid
 * @property string $briefing_uuid
 * @property string $material_uuid
 *
 * @property User $author
 * @property Employee $employee
 * @property Material $material
 * @property Test $test
 * @property Briefing $briefing
 * @property TaskComment[]|Collection $comments
 */
class Task extends BaseModel
{
    use HasFactory;

    public const STATUSES = [
        'Новая',
        'В работе',
        'Завершена',
        'Отклонена',
        'Остановлена',
        'Требует уточнения',
    ];

    public const TYPES = [
        'Обучение',
        'Разработка',
        'Проектирование',
        'Инфраструктура',
        'Техподдержка',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_uuid', 'uuid');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_uuid', 'uuid');
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'test_uuid', 'uuid');
    }

    public function briefing(): BelongsTo
    {
        return $this->belongsTo(Briefing::class, 'briefing_uuid', 'uuid');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TaskComment::class)->orderBy('created_at');
    }
}

