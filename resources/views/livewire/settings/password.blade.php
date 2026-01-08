<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => $validated['password'],
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section class="bg-gray-50 min-h-[calc(100vh-8rem)]">
    <div class="max-w-7xl mx-auto px-6 py-12 mt-8">
        <!-- Page Heading -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Instellingen</h1>
            <p class="mt-2 text-gray-600">Beheer je profiel en accountinstellingen</p>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-6">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <nav class="flex border-b">
                    <a href="{{ route('profile.edit') }}"
                       wire:navigate
                       class="flex items-center px-6 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profiel
                    </a>
                    <a href="{{ route('user-password.edit') }}"
                       class="flex items-center px-6 py-3 text-sm font-medium border-b-2 border-indigo-500 text-indigo-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Wachtwoord
                    </a>
                </nav>
            </div>
        </div>

        <!-- Password Card -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Wachtwoord wijzigen</h2>
                <p class="text-gray-600 mb-6">Zorg ervoor dat je account een lang, willekeurig wachtwoord gebruikt om veilig te blijven</p>

                <form method="POST" wire:submit="updatePassword" class="space-y-6">
                    <flux:input
                        wire:model="current_password"
                        :label="__('Current password')"
                        type="password"
                        required
                        autocomplete="current-password"
                    />
                    <flux:input
                        wire:model="password"
                        :label="__('New password')"
                        type="password"
                        required
                        autocomplete="new-password"
                    />
                    <flux:input
                        wire:model="password_confirmation"
                        :label="__('Confirm Password')"
                        type="password"
                        required
                        autocomplete="new-password"
                    />

                    <div class="flex items-center gap-4">
                        <flux:button variant="primary" type="submit" class="w-auto px-8" data-test="update-password-button">
                            {{ __('Save') }}
                        </flux:button>

                        <x-action-message on="password-updated">
                            {{ __('Saved.') }}
                        </x-action-message>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
