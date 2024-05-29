<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class BriefingEmployee
 * @package App\Models
 *
 * @property string $briefing_uuid
 * @property string $employee_uuid
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Briefing $briefing
 * @property Employee $employee
 */
class BriefingEmployee extends Pivot
{
    public function briefing(): BelongsToMany
    {
        return $this->belongsToMany(Briefing::class, 'briefing_uuid', 'uuid');
    }

    public function employee(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'employee_uuid', 'uuid');
    }
}
