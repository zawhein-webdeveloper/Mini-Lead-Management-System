<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Rules for HTTP form posts (email / password).
     *
     * @return array<string, array<int, string|\Illuminate\Contracts\Validation\ValidationRule>>
     */
    public function rules(): array
    {
        return [
            'email' => $this->emailRules(),
            'password' => $this->passwordRules(),
        ];
    }

    /**
     * Rules for Livewire {@see \App\Livewire\Forms\LoginForm} (prefixed keys).
     *
     * @return array<string, array<int, string|\Illuminate\Contracts\Validation\ValidationRule>>
     */
    public static function livewireRules(): array
    {
        $self = new self;

        return [
            'form.email' => $self->emailRules(),
            'form.password' => $self->passwordRules(),
        ];
    }

    /**
     * @return array<int, string|\Illuminate\Contracts\Validation\ValidationRule>
     */
    protected function emailRules(): array
    {
        return [
            'required',
            'string',
            'email',
            'max:180',
            'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
        ];
    }

    /**
     * @return array<int, string|\Illuminate\Contracts\Validation\ValidationRule>
     */
    protected function passwordRules(): array
    {
        return [
            'required',
            'string',
            'min:1',
            'max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('validation.required', ['attribute' => __('Email')]),
            'email.string' => __('validation.string', ['attribute' => __('Email')]),
            'email.email' => __('validation.email', ['attribute' => __('Email')]),
            'email.max' => __('validation.max.string', ['attribute' => __('Email'), 'max' => 180]),
            'email.regex' => __('validation.email', ['attribute' => __('Email')]),

            'password.required' => __('validation.required', ['attribute' => __('Password')]),
            'password.string' => __('validation.string', ['attribute' => __('Password')]),
            'password.min' => __('validation.min.string', ['attribute' => __('Password'), 'min' => 1]),
            'password.max' => __('validation.max.string', ['attribute' => __('Password'), 'max' => 255]),
        ];
    }

    /**
     * Messages keyed for Livewire form properties (form.email, form.password).
     *
     * @return array<string, string>
     */
    public static function livewireMessages(): array
    {
        $req = new self;
        $messages = $req->messages();
        $prefixed = [];
        foreach ($messages as $key => $message) {
            $prefixed['form.'.$key] = $message;
        }

        return $prefixed;
    }
}
