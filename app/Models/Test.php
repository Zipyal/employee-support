<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class Test
 * @package App\Models
 *
 * @property string $category
 * @property string $subject
 * @property string $url
 *
 * @property Employee $author
 * @property TestQuestion[]|Collection $questions
 * @property Task[]|Collection $tasks
 */
class Test extends Model
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
        return $this->belongsTo(Employee::class, 'author_uuid', 'uuid');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(TestQuestion::class)->orderBy('created_at');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}

