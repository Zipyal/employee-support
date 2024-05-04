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
 * @property string $subject
 * @property string $category
 * @property string $text
 *
 * @property Mentor $mentor
 * @property Task[]|Collection $tasks
 */
class Material extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at',
    ];

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Mentor::class, 'mentor_uuid', 'uuid');
    }

    public function tasks(): HasMany
    {
        return $this->HasMany(Task::class);
    }
}
