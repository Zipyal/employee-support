<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Class EmploymentContract
 * @package App\Models
 *
 * @property string $ID_ТрудДоговора
 * @property string $ID_Сотрудник
 * @property string $Фамилия
 * @property string $Имя
 * @property string $Отчество
 * @property string $Отдел
 * @property string $Должность
 * @property float $Оклад
 * @property int $Ставка
 * @property Carbon $ДатаОформления
 * @property Carbon $ДатаРождения
 * @property Carbon $ДатаОкончания
 * @property string $МестоРегистрации
 *
 * @property Employee $employee
 */
class EmploymentContract extends Model
{
    use HasFactory;
    use HasUuids;

    public $table = 'ТрудовойДоговор';
    public $timestamps = false;
    protected $primaryKey ='ID_ТрудДоговора';
    protected $keyType = 'string';

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }
}
