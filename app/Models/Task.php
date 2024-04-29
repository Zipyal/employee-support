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
 * @property int $ID_Задачи
 * @property string $Статус
 * @property string $ТипЗадачи
 * @property Carbon $ДатаНазначения
 * @property Carbon $СрокВыполнения
 * @property string $Комментарий
 * @property string $ID_Сотрудника
 * @property string $ID_Статьи
 * @property string $ID_Теста
 * @property string $ID_Инструктажа
 *
 * @property Employee $employee
 * @property Material $material
 * @property Test $test
 * @property Briefing $briefing
 */
class Task extends Model
{
    use HasFactory;

    public $table = 'Задача';
    public $timestamps = false;
    protected $primaryKey ='ID_Задачи';
    protected $keyType = 'int';
    protected string $autoincrement = 'true';

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'ID_Сотрудника', 'ID_Сотрудника');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'ID_Статьи', 'ID_Статьи');
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'ID_Теста', 'ID_Теста');
    }

    public function briefing(): BelongsTo
    {
        return $this->belongsTo(Briefing::class, 'ID_Инструктажа', 'ID_Инструктаж');
    }
}

