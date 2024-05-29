<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\BelongsToManyRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class Test
 * @package App\Models
 *
 * @property string $uuid
 * @property string $category
 * @property string $subject
 * @property int $author_uuid
 *
 * @property User $author
 * @property TestQuestion[]|Collection $questions
 * @property Task[]|Collection $tasks
 // * @property Employee[]|Collection $employees
 */
class Test extends BaseModel
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
        return $this->belongsTo(User::class, 'author_uuid', 'uuid');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(TestQuestion::class)->orderBy('created_at');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /*public function employees(): HasManyThrough
    {
        return $this->hasManyThrough(Employee::class, Task::class, 'employee_uuid', 'uuid', 'task_id', 'id');
        // return $this->through('tasks')->has('employee');
        // return $this->throughTasks()->hasEmployee();
    }*/

    public function resultByUser(?User $user = null): ?Model
    {
        if (null === $user) {
            $user = auth()->user();
        }

        return TestResult::query()
            ->where('test_uuid', '=', $this->uuid)
            ->where('user_uuid', '=', $user->uuid)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function isSolvedByUser(?User $user = null): ?bool
    {
        if (null === $user) {
            $user = auth()->user();
        }

        /** @var TestResult $lastResult */
        $lastResult = $this->resultByUser($user);

        return $lastResult?->is_closed;
    }
}

