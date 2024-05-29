<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $uuid
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class BaseModel extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m-d H:i:s';
}
