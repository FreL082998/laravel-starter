<?php

declare(strict_types=1);

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Validation Request for creating a new user.
 */
class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['nullable', 'string', 'exists:roles,name'],
        ];
    }

    /**
     * Get custom error messages for validation failures.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => _('response.error.auth.name_required'),
            'name.max' => _('response.error.auth.name_max'),
            'email.required' => _('response.error.auth.email_required'),
            'email.email' => _('response.error.auth.email_invalid'),
            'email.unique' => _('response.error.user.email_unique'),
            'phone.unique' => _('response.error.user.phone_unique'),
            'password.min' => _('response.error.user.password_min'),
        ];
    }
}
