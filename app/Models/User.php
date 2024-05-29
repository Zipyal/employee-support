<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class Briefing
 * @package App\Models
 *
 * @property string $uuid
 * @property string $name
 * @property string $email
 * @property Carbon $email_verified_at
 * @property string $password
 *
 * @property Employee $employee
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasUuids, HasRoles;

    public const STATUS_NONE = 'none';
    public const STATUS_BANNED = 'banned';
    public const STATUS_ACTIVE = 'active';

    public const STATUSES = [
        self::STATUS_NONE => 'не создана',
        self::STATUS_BANNED => 'заблокирована',
        self::STATUS_ACTIVE => 'активна',
    ];

    public const ROLE_EMPLOYEE = 1;
    public const ROLE_MENTOR = 2;
    public const ROLE_ADMIN = 3;

    public const ROLES = [
        self::ROLE_EMPLOYEE => 'Сотрудник',
        self::ROLE_MENTOR => 'Наставник',
        self::ROLE_ADMIN => 'Администратор',
    ];

    protected $primaryKey = 'uuid';
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }
}
