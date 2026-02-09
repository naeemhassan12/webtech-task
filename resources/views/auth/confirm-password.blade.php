<x-guest-layout>
    <div class="auth-card animate-fade-in">
        <div class="auth-logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-white" />
            </a>
        </div>
        
        <h2 class="auth-title">Secure Area</h2>
        <p class="auth-subtitle">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="alert-error mt-2" />
            </div>

            <button type="submit" class="btn-primary mt-4">
                {{ __('Confirm Password') }}
            </button>
        </form>
    </div>
</x-guest-layout>
