<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Briefing
 * @package App\Models
 *
 * @property string $ID_Инструктаж
 * @property string $Тема
 * @property string $Материал
 *
 * @property Task[]|Collection $tasks
 */
class Briefing extends Model
{
    use HasFactory;
    use HasUuids;

    public $table = 'Инструктаж';
    public $timestamps = false;
    protected $primaryKey = 'ID_Инструктаж';
    protected $keyType = 'string';

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Mentor::class, 'ID_Наставника', 'ID_Наставника');
    }

    public function tasks(): HasMany
    {
        return $this->HasMany(Task::class);
    }
}
