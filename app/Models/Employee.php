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
 * @property string $ID_Сотрудника
 * @property string $Фамилия
 * @property string $Имя
 * @property string $Отчество
 * @property string $Роль
 * @property string $Отдел
 * @property string $Должность
 * @property string $Образование
 * @property string $Опыт
 * @property Carbon $ДатаРождения
 * @property string $Телефон
 * @property string $Почта
 * @property string $ДопОбразование
 * @property string $ID_Наставника
 * @property string $ID_ТрудовогоДоговора
 *
 * @property Mentor $mentor
 * @property EmploymentContract $employmentContract
 * @property Task[]|Collection $tasks
 */
class Employee extends Model
{
    use HasFactory;
    use HasUuids;

    public $table = 'Сотрудники';
    public $timestamps = false;
    protected $primaryKey ='ID_Сотрудника';
    protected $keyType = 'string';

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Mentor::class, 'ID_Наставника', 'ID_Наставника');
    }

    public function employmentContract(): BelongsTo
    {
        return $this->belongsTo(EmploymentContract::class, 'ID_ТрудовогоДоговора', 'ID_ТрудДоговора');
    }

    public function tasks(): HasMany
    {
        return $this->HasMany(Task::class);
    }
}
