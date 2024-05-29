<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @property bool $published
 * @property int $author_uuid
 *
 * @property User $author
 * @property Task[]|Collection $tasks
 */
class Material extends BaseModel
{
    use HasFactory;
    use HasUuids;
    use HasUploadImageTrait;

    public $incrementing = false;
    protected $primaryKey = 'uuid';

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_uuid', 'uuid');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
