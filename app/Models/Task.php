<?php

namespace App\Models;

use Carbon\Carbon;
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
 * @property int $id
 * @property string $subject
 * @property string $status
 * @property string $type
 * @property string $priority
 * @property Date $start_date
 * @property Date $end_date
 * @property string $description
 * @property int $weight
 * @property string $employee_uuid
 * @property string $test_uuid
 * @property string $briefing_uuid
 * @property string $material_uuid
 * @property string $author_uuid
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
    use HasUploadImageTrait;

    public const STATUSES = [
        'Новая',
        'Требует уточнения',
        'В работе',
        'Решена',
        'Отклонена',
        'Остановлена',
    ];

    public const TYPES = [
        'Обучение',
        'Разработка',
        'Проектирование',
        'Инфраструктура',
        'Техподдержка',
    ];

    public const PRIORITY_LOW = 'Низкий';
    public const PRIORITY_NORMAL = 'Нормальный';
    public const PRIORITY_HIGH = 'Высокий';
    public const PRIORITY_URGENT = 'Срочный';
    public const PRIORITY_INSTANT = 'Немедленный';

    public const PRIORITIES = [
        self::PRIORITY_LOW,
        self::PRIORITY_NORMAL,
        self::PRIORITY_HIGH,
        self::PRIORITY_URGENT,
        self::PRIORITY_INSTANT,
    ];

    public const PRIORITY_CSS_CLASSES = [
        self::PRIORITY_LOW => 'task-priority-low',
        self::PRIORITY_NORMAL => 'task-priority-normal',
        self::PRIORITY_HIGH => 'task-priority-high',
        self::PRIORITY_URGENT => 'task-priority-urgent',
        self::PRIORITY_INSTANT => 'task-priority-instant',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_uuid', 'uuid');
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

