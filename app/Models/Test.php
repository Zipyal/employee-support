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
 * @property string $category
 * @property string $subject
 * @property string $url
 *
 * @property Task[]|Collection $tasks
 */
class Test extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at',
    ];

    public function tasks(): HasMany
    {
        return $this->HasMany(Task::class);
    }
}

