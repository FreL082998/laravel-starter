<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Response Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during response for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'common' => [],
    'success' => [
        'auth' => [
            'logged_in' => 'Logged in successfully',
            'logged_out' => 'Logged out successfully',
            'registered' => 'Account created successfully',
            'password_reset' => 'Password reset successfully',
        ],
        'user' => [
            'created' => 'User created successfully',
            'updated' => 'User updated successfully',
            'deleted' => 'User deleted successfully',
        ],
        'role' => [
            'created' => 'Role created successfully',
            'updated' => 'Role updated successfully',
            'deleted' => 'Role deleted successfully',
        ],
        'permission' => [
            //
        ],
    ],
    'error' => [
        'auth' => [
            'unauthorized' => 'Unauthorized',
            'unauthenticated' => 'You must be logged in to access this resource',
            'invalid_credentials' => 'Invalid email or password',
            'token_expired' => 'Token has expired',
            'token_invalid' => 'Invalid token',
            'email_required' => 'Email is required',
            'email_invalid' => 'Please provide a valid email address',
            'email_not_found' => 'No user found with this email address',
            'password_required' => 'Password is required',
            'password_min' => 'Password must be at least 8 characters',
            'name_required' => 'Name is required',
            'name_max' => 'Name must not exceed 255 characters',
            'email_already_registered' => 'This email address is already registered',
            'phone_required' => 'Phone number is required',
            'phone_already_registered' => 'This phone number is already registered',
            'password_confirmation_mismatch' => 'Password confirmation does not match',
        ],
        'user' => [
            'not_found' => 'User not found',
            'unauthorized' => 'Only admins can manage users',
            'invalid_credentials' => 'Invalid email or password',
            'email_required' => 'Email is required',
            'email_unique' => 'Email already exists',
            'password_required' => 'Password is required',
            'password_min' => 'Password must be at least 8 characters',
            'name_required' => 'Name is required',
            'phone_unique' => 'Phone number already exists',
        ],
        'role' => [
            'failed_to_update' => 'Failed to update role',
            'not_found' => 'Role not found',
            'unauthorized' => 'Only admins can manage roles',
            'name_required' => 'Role name is required',
            'name_unique' => 'Role name already exists',
            'description_required' => 'Role description is required',
            'name_already_exists' => 'A role with this name already exists.',
            'permissions_not_found' => 'Some permissions do not exist.',
        ],
        'permission' => [
            //
        ],
    ],
];
