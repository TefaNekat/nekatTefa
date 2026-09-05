<?php

use App\Livewire\Forms\LoginForm;
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
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-7">
        <h1 class="font-display text-2xl font-bold text-[var(--color-neutral-900)]">Selamat datang kembali</h1>
        <p class="mt-2 text-sm leading-6 text-[var(--color-neutral-500)]">Masuk untuk melanjutkan percakapan dengan admin jurusan.</p>
    </div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-[var(--color-neutral-700)]" />
            <x-text-input wire:model="form.email" id="email" class="mt-2 block h-10 w-full rounded-lg border-[var(--color-neutral-200)] text-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-[var(--color-neutral-700)]" />

            <x-text-input wire:model="form.password" id="password" class="mt-2 block h-10 w-full rounded-lg border-[var(--color-neutral-200)] text-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-[var(--color-neutral-200)] text-[var(--color-primary-600)] focus:ring-[var(--color-primary-500)]" name="remember">
                <span class="ms-2 text-sm text-[var(--color-neutral-500)]">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 rounded-lg bg-[var(--color-primary-500)] px-4 py-2.5 text-xs font-bold hover:bg-[var(--color-primary-600)] focus:ring-[var(--color-primary-500)]">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
