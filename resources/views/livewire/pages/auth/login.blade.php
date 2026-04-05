<?php

use App\Http\Requests\Auth\LoginRequest;
use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate(LoginRequest::livewireRules(), LoginRequest::livewireMessages());

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

@php
    $field = 'self-stretch block mt-0 min-w-0 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 shadow-sm text-sm py-2.5 px-3 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 dark:focus:ring-offset-gray-900';
@endphp

<div class="min-w-0 text-left">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-normal text-gray-900 dark:text-gray-100 tracking-tight">{{ __('Sign in') }}</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Use your credentials to open the lead list.') }}</p>
    </div>

    <x-auth-session-status class="mb-4 rounded-md bg-green-50 dark:bg-green-900/30 px-3 py-2 text-center text-sm text-green-800 dark:text-green-200" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col min-w-0">
        <div class="mb-3 flex flex-col min-w-0">
            <x-input-label for="email" :value="__('Email')" class="!mb-1 !text-sm !font-medium !text-gray-700 dark:!text-gray-300" />
            <x-text-input
                wire:model="form.email"
                id="email"
                class="{{ $field }}"
                type="email"
                name="email"
                required
                autofocus
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-sm" />
        </div>

        <div class="mb-3 flex flex-col min-w-0">
            <x-input-label for="password" :value="__('Password')" class="!mb-1 !text-sm !font-medium !text-gray-700 dark:!text-gray-300" />
            <x-text-input
                wire:model="form.password"
                id="password"
                class="{{ $field }}"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-sm" />
        </div>

        <div class="mb-6 flex items-center">
            <input
                wire:model="form.remember"
                id="remember"
                type="checkbox"
                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-900 dark:focus:ring-offset-gray-900"
                name="remember"
            >
            <label for="remember" class="ms-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer select-none">{{ __('Remember me') }}</label>
        </div>

        <button
            type="submit"
            class="self-stretch rounded-md border border-transparent bg-blue-600 py-2.5 text-sm font-medium text-dark shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition"
        >
            {{ __('Log in') }}
        </button>

        <p class="mt-5 text-center text-sm text-gray-600 dark:text-gray-400">
            <a
                href="{{ route('register') }}"
                wire:navigate
                class="font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline underline-offset-2"
            >
                {{ __('Create an account') }}
            </a>
        </p>
    </form>
</div>
