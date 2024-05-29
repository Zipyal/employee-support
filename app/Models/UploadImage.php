<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class UploadImage
 * @package App\Models
 *
 * @property string $uuid
 * @property string $image_filepath
 * @property string|int $model_id
 * @property string $model_type
 *
 * @property Model $imageable
 */
class UploadImage extends BaseModel
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

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
