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
 * @property string $subject
 * @property string $text
 *
 * @property Employee $author
 * @property Task[]|Collection $tasks
 */
class Briefing extends Model
{
    use HasFactory;
    use HasUuids;

    public $incrementing = false;
    protected $primaryKey = 'uuid';

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'author_uuid', 'id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
