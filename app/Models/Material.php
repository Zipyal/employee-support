<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Material
 * @package App\Models
 *
 * @property string $ID_Статьи
 * @property string $Категория
 * @property string $Тема
 * @property string $ID_Наставника
 *
 * @property Mentor $mentor
 * @property Task[]|Collection $tasks
 */
class Material extends Model
{
    use HasFactory;
    use HasUuids;

    public $table = 'Материалы';
    public $timestamps = false;
    protected $primaryKey = 'ID_Статьи';
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
