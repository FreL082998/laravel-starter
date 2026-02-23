<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * LoginRequest validates user login credentials.
 *
 * Validates that the provided email and password meet the requirements for authentication.
 *
 * @category Authentication
 */
final class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool True for any user (guest or authenticated)
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => __('response.error.auth.email_required'),
            'email.email' => __('response.error.auth.email_invalid'),
            'email.exists' => __('response.error.auth.email_not_found'),
            'password.required' => __('response.error.auth.password_required'),
            'password.min' => __('response.error.auth.password_min'),
        ];
    }
}
