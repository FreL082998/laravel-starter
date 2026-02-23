<?php

declare(strict_types=1);

namespace Modules\User\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Models\User;

/****
 * UserRegistered is an event that is dispatched when a new user is registered.
 *
 * It contains the User model instance of the newly registered user and can be
 * listened to for performing actions such as sending welcome emails or logging
 * registration activity.
 *
 * @category Events
 */
class UserRegistered
{
    // Use the Dispatchable, InteractsWithSockets, and SerializesModels traits
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param  User  $user  The user that was registered
     * @return void
     */
    public function __construct(
        public User $user,
    ) {}
}
