<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TestQuestion
 * @package App\Models
 *
 * @property string $text
 *
 * @property Test $test
 * @property TestAnswerVariant[]|Collection $answerVariants
 */
class TestQuestion extends BaseModel
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

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'test_uuid', 'uuid');
    }

    public function answerVariants(): HasMany
    {
        return $this->hasMany(TestAnswerVariant::class)->orderBy('created_at');
    }
}

