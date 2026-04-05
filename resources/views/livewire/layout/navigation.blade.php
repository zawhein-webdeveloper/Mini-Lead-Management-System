<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-3 sm:px-5 lg:px-8">
        <div class="flex justify-between h-14 sm:h-16">
            <div class="flex min-w-0 flex-1">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('leads.index') }}" wire:navigate class="truncate">
                        <x-application-logo class="block h-8 w-auto sm:h-9 fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:ms-18 sm:flex sm:items-center">
                    <h3 class="mb-0" style="font-size:1rem; font-weight:600;">{{ __('Leads Management') }}</h3>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:shrink-0 sm:ms-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button type="button" class="inline-flex items-center max-w-[12rem] px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <span class="truncate">{{ auth()->user()->name }}</span>
                            <div class="ms-1 shrink-0">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button type="button" @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-100 dark:border-gray-700">
        <div class="pt-2 pb-3 space-y-1 px-3 fs-3">
            <div class="text-base font-semibold text-gray-800 dark:text-gray-200">{{ __('Leads Management') }}</div>
        </div>

        <div class="pt-3 pb-3 border-t border-gray-200 dark:border-gray-600 px-3">
            <div class="font-medium text-base text-gray-800 dark:text-gray-200 truncate">{{ auth()->user()->name }}</div>
            <div class="font-medium text-sm text-gray-500 truncate">{{ auth()->user()->email }}</div>

            <div class="mt-3 space-y-1">
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
