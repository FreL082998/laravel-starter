<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * RegisterRequest validates user registration fields.
 *
 * Validates that all required registration fields are present and unique,
 * with password confirmation for data integrity.
 *
 * @category Authentication
 */
final class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'string', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
            'name.required' => __('response.error.auth.name_required'),
            'name.max' => __('response.error.auth.name_max'),
            'email.required' => __('response.error.auth.email_required'),
            'email.email' => __('response.error.auth.email_invalid'),
            'email.unique' => __('response.error.auth.email_already_registered'),
            'phone.required' => __('response.error.auth.phone_required'),
            'phone.unique' => __('response.error.auth.phone_already_registered'),
            'password.required' => __('response.error.auth.password_required'),
            'password.min' => __('response.error.auth.password_min'),
            'password.confirmed' => __('response.error.auth.password_confirmation_mismatch'),
        ];
    }
}
