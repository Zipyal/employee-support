<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Mentor
 * @package App\Models
 *
 * @property string ID_Наставника
 * @property string $Фамилия
 * @property string $Имя
 * @property string $Отчество
 * @property string $Телефон
 * @property string $Почта
 * @property string $Роль
 * @property string $Должность
 * @property string $Отдел
 * @property string $Образования
 * @property string $ДопОбразование
 * @property string $ОпытРаботы
 *
 * @property Material[]|Collection $materials
 * @property Employee[]|Collection $employees
 */
class Mentor extends Model
{
    use HasFactory;
    use HasUuids;

    public $table = 'Наставники';
    public $timestamps = false;
    protected $primaryKey ='ID_Наставника';
    protected $keyType = 'string';

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
