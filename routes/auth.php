<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('/', 'pages.auth.login')
        ->name('login');

    Volt::route('/register', 'pages.auth.register')
        ->name('register');
});

Route::redirect('/login', '/');
