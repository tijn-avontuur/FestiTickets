<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
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
                       class="flex items-center px-6 py-3 text-sm font-medium border-b-2 border-indigo-500 text-indigo-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profiel
                    </a>
                    <a href="{{ route('user-password.edit') }}"
                       wire:navigate
                       class="flex items-center px-6 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Wachtwoord
                    </a>
                </nav>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
            <div class="px-6 py-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Profiel</h2>
                <p class="text-gray-600 mb-6">Update je naam en e-mailadres</p>

                <form wire:submit="updateProfileInformation" class="space-y-6">
                    <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

                    <div>
                        <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                        @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                            <div>
                                <flux:text class="mt-4">
                                    {{ __('Your email address is unverified.') }}

                                    <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </flux:link>
                                </flux:text>

                                @if (session('status') === 'verification-link-sent')
                                    <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </flux:text>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-4">
                        <flux:button variant="primary" type="submit" class="w-auto px-8" data-test="update-profile-button">
                            {{ __('Save') }}
                        </flux:button>

                        <x-action-message on="profile-updated">
                            {{ __('Saved.') }}
                        </x-action-message>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Account Card -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-8">
                <livewire:settings.delete-user-form />
            </div>
        </div>
    </div>
</section>
