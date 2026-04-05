<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string|\Illuminate\Contracts\Validation\ValidationRule>>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:50',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:180',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                Rule::unique(User::class),
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:30',
                'confirmed',
            ],
            'password_confirmation' => [
                'required',
                'string',
                'min:8',
                'max:30',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('Name')]),
            'name.string' => __('validation.string', ['attribute' => __('Name')]),
            'name.max' => __('validation.max.string', ['attribute' => __('Name'), 'max' => 50]),

            'email.required' => __('validation.required', ['attribute' => __('Email')]),
            'email.string' => __('validation.string', ['attribute' => __('Email')]),
            'email.email' => __('validation.email', ['attribute' => __('Email')]),
            'email.max' => __('validation.max.string', ['attribute' => __('Email'), 'max' => 180]),
            'email.regex' => __('validation.email', ['attribute' => __('Email')]),
            'email.unique' => __('validation.unique', ['attribute' => __('Email')]),

            'password.required' => __('validation.required', ['attribute' => __('Password')]),
            'password.string' => __('validation.string', ['attribute' => __('Password')]),
            'password.min' => __('validation.min.string', ['attribute' => __('Password'), 'min' => 8]),
            'password.max' => __('validation.max.string', ['attribute' => __('Password'), 'max' => 30]),
            'password.confirmed' => __('validation.confirmed', ['attribute' => __('Password')]),

            'password_confirmation.required' => __('validation.required', ['attribute' => __('Confirm Password')]),
            'password_confirmation.string' => __('validation.string', ['attribute' => __('Confirm Password')]),
            'password_confirmation.min' => __('validation.min.string', ['attribute' => __('Confirm Password'), 'min' => 8]),
            'password_confirmation.max' => __('validation.max.string', ['attribute' => __('Confirm Password'), 'max' => 30]),
        ];
    }
}
