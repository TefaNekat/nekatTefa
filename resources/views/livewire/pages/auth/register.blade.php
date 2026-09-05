<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-7">
        <h1 class="font-display text-2xl font-bold text-[var(--color-neutral-900)]">Buat akun customer</h1>
        <p class="mt-2 text-sm leading-6 text-[var(--color-neutral-500)]">Daftar untuk menghubungi admin dan mendapatkan informasi produk.</p>
    </div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-sm font-semibold text-[var(--color-neutral-700)]" />
            <x-text-input wire:model="name" id="name" class="mt-2 block h-10 w-full rounded-lg border-[var(--color-neutral-200)] text-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-[var(--color-neutral-700)]" />
            <x-text-input wire:model="email" id="email" class="mt-2 block h-10 w-full rounded-lg border-[var(--color-neutral-200)] text-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Nomor WhatsApp')" class="text-sm font-semibold text-[var(--color-neutral-700)]" />
            <x-text-input wire:model="phone" id="phone" class="mt-2 block h-10 w-full rounded-lg border-[var(--color-neutral-200)] text-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]" type="tel" name="phone" required autocomplete="tel" placeholder="081234567890" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

<!-- Password -->

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-[var(--color-neutral-700)]" />

            <x-text-input wire:model="password" id="password" class="mt-2 block h-10 w-full rounded-lg border-[var(--color-neutral-200)] text-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-semibold text-[var(--color-neutral-700)]" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="mt-2 block h-10 w-full rounded-lg border-[var(--color-neutral-200)] text-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4 rounded-lg bg-[var(--color-primary-500)] px-4 py-2.5 text-xs font-bold hover:bg-[var(--color-primary-600)] focus:ring-[var(--color-primary-500)]">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
