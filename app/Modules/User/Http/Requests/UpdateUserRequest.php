<?php

declare(strict_types=1);

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Form Validation Request for updating an existing user.
 */
class UpdateUserRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users', 'email')->ignore($this->route('user')),
            ],
            'phone' => [
                'nullable',
                'string',
                Rule::unique('users', 'phone')->ignore($this->route('user')),
            ],
            'password' => ['nullable', 'string', 'min:8'],
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
            'name.max' => _('response.error.auth.name_max'),
            'email.email' => _('response.error.auth.email_invalid'),
            'email.unique' => _('response.error.user.email_unique'),
            'phone.unique' => _('response.error.user.phone_unique'),
            'password.min' => _('response.error.user.password_min'),
        ];
    }
}
