<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class Task
 * @package App\Models
 *
 * @property string $status
 * @property string $type
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property string $description
 *
 * @property Employee $employee
 * @property Material $material
 * @property Test $test
 * @property Briefing $briefing
 */
class Task extends Model
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
        'uuid',
        'created_at',
        'updated_at',
    ];

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
}

