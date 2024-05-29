<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property UploadImage[]|Collection $images
 */
trait HasUploadImageTrait
{
    public function images(): MorphMany
    {
        return $this->morphMany(UploadImage::class, 'imageable', 'imageable_type', 'imageable_id');
    }
}
