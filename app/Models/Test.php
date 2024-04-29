<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Test
 * @package App\Models
 *
 * @property string $ID_Теста
 * @property string $Категория
 * @property string $Тема
 * @property string $СсылкаНаТест
 *
 * @property Task[]|Collection $tasks
 */
class Test extends Model
{
    use HasFactory;
    use HasUuids;

    public $table = 'Тест';
    public $timestamps = false;
    protected $primaryKey ='ID_Теста';
    protected $keyType = 'string';

    public function tasks(): HasMany
    {
        return $this->HasMany(Task::class);
    }
}

