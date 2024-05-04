<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Class EmploymentContract
 * @package App\Models
 *
 * @property string $position
 * @property string $department
 * @property float $salary
 * @property int $rate
 * @property Carbon $register_date
 * @property Carbon $end_date
 * @property string $register_address
 *
 * @property Employee $employee
 */
class EmploymentContract extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at',
    ];

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }
}
