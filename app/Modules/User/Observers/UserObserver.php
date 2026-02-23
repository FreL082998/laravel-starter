<?php

declare(strict_types=1);

namespace Modules\User\Observers;

use Modules\User\Events\UserRegistered;
use Modules\User\Models\User;
use Modules\User\Notifications\WelcomeEmail;

/**
 * UserObserver handles model events for the User model.
 *
 * It listens for created, updated, and deleted events to perform actions
 * such as dispatching events and sending notifications.
 *
 * @category Observers
 */
class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  User  $user  The user that was created
     */
    public function created(User $user): void
    {
        // Dispatch UserRegistered event
        UserRegistered::dispatch($user);

        // Send welcome email
        $user->notify(new WelcomeEmail);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  User  $user  The user that was updated
     */
    public function updated(User $user): void
    {
        // Handle user updates if needed
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  User  $user  The user that was deleted
     */
    public function deleted(User $user): void
    {
        // Revoke all tokens on user deletion
        $user->tokens()->delete();
    }
}
