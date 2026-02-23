<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Irabbi360\LaravelAttributeMask\Concern\HasMaskedAttributes;
use Laravel\Passport\HasApiTokens;
use Shared\Traits\HasUuid;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

/**
 * User is the main model for user management.
 *
 * It includes authentication, role management, activity logging, and more.
 *
 * @category Models
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasMaskedAttributes;
    use HasRoles;
    use HasUuid;
    use LogsActivity;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'users';

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be masked when serialized.
     *
     * @var list<string>
     */
    protected array $maskable = ['email', 'phone'];

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

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    /**
     * The "booted" method of the model.
     *
     * This method is called after the model is booted and is used to define
     * model event listeners for creating, updating, and deleting events.
     */
    public static function booted(): void
    {
        static::creating(function (self $model): void {
            activity()
                ->causedBy($model)
                ->log('User created');
        });

        static::updating(function (self $model): void {
            activity()
                ->causedBy($model)
                ->log('User updated');
        });

        static::deleting(function (self $model): void {
            activity()
                ->causedBy($model)
                ->log('User deleted');
        });
    }

    /**
     * Get the options for activity logging.
     *
     * This method configures the activity log to only log changes to fillable
     * attributes and to only log when there are actual changes (dirty attributes).
     *
     * @return \Spatie\Activitylog\LogOptions The configured log options
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->logFillable();
    }

    /**
     * Get all roles for the user.
     */
    public function rolesList(): Collection
    {
        return $this->roles()->get();
    }

    /**
     * Check if user has all specified roles.
     */
    public function hasAllRoles(array $roles): bool
    {
        return $this->roles()->whereIn('name', $roles)->count() === count($roles);
    }

    /**
     * Scope: filter by role
     */
    public function scopeByRole(Builder $query, string $role): Builder
    {
        return $query->whereHas('roles', fn (Builder $q) => $q->where('name', $role));
    }

    /**
     * Scope: active users
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('deleted_at');
    }
}
