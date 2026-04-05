<?php

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest-register')] class extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $registerRequest = new RegisterRequest;
        $validated = $this->validate($registerRequest->rules(), $registerRequest->messages());

        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'password' => $validated['password'],
        ]);

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(RouteServiceProvider::HOME, navigate: false);
    }
}; ?>

@php
    $field = 'self-stretch block mt-0 min-w-0 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 shadow-sm text-sm py-2.5 px-3 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 dark:focus:ring-offset-gray-900';
@endphp

<div class="min-w-0 text-left">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-normal text-gray-900 dark:text-gray-100 tracking-tight">{{ __('Create account') }}</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Register to manage leads in one place.') }}</p>
    </div>

    <form wire:submit="register" class="flex flex-col min-w-0">
        <div class="mb-3 flex flex-col min-w-0">
            <x-input-label for="name" :value="__('Name')" class="!mb-1 !text-sm !font-medium !text-gray-700 dark:!text-gray-300" />
            <x-text-input wire:model="name" id="name" class="{{ $field }}" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm" />
        </div>

        <div class="mb-3 flex flex-col min-w-0">
            <x-input-label for="email" :value="__('Email')" class="!mb-1 !text-sm !font-medium !text-gray-700 dark:!text-gray-300" />
            <x-text-input wire:model="email" id="email" class="{{ $field }}" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm" />
        </div>

        <div class="mb-3 flex flex-col min-w-0">
            <x-input-label for="password" :value="__('Password')" class="!mb-1 !text-sm !font-medium !text-gray-700 dark:!text-gray-300" />
            <x-text-input wire:model="password" id="password" class="{{ $field }}" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm" />
        </div>

        <div class="mb-6 flex flex-col min-w-0">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="!mb-1 !text-sm !font-medium !text-gray-700 dark:!text-gray-300" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="{{ $field }}" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm" />
        </div>

        <button
            type="submit"
            class="self-stretch rounded-md border border-transparent bg-blue-600 py-2.5 px-4 text-sm font-medium text-dark shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 transition"
        >
            {{ __('Register') }}
        </button>

        <p class="mt-5 text-center text-sm text-gray-600 dark:text-gray-400">
            <a
                href="{{ route('login') }}"
                wire:navigate
                class="font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline underline-offset-2"
            >
                {{ __('Already registered?') }}
            </a>
        </p>
    </form>
</div>
