<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shared\Traits\HasUuid;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Role is a model representing a user role in the system.
 *
 * It extends the Spatie\Permission\Models\Role class and includes additional functionality
 * such as UUID generation, activity logging, and soft deletes.
 *
 * @category Models
 */
class Role extends SpatieRole
{
    use HasFactory;
    use HasUuid;
    use LogsActivity;
    use SoftDeletes;

    // Define the database table used by this model
    protected $table = 'roles';

    // Define the attributes that are mass assignable
    protected $guarded = [];

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
                ->log('Role created', ['name' => $model->name]);
        });

        static::updating(function (self $model): void {
            activity()
                ->log('Role updated', ['name' => $model->name]);
        });

        static::deleting(function (self $model): void {
            activity()
                ->log('Role deleted', ['name' => $model->name]);
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
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): RoleFactory
    {
        return RoleFactory::new();
    }

    /**
     * Get users with this role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'model_has_roles',
            'role_id',
            'model_id'
        );
    }

    /**
     * Scope: active roles
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('deleted_at');
    }
}
