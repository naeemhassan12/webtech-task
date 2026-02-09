<x-guest-layout>
    <div class="auth-card animate-fade-in">
        <div class="auth-logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-white" />
            </a>
        </div>
        
        <h2 class="auth-title">Update Password</h2>
        <p class="auth-subtitle">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="name@company.com" />
                @if ($errors->has('email'))
                    <span class="form-error">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">{{ __('New Password') }}</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                @if ($errors->has('password'))
                    <span class="form-error">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">{{ __('Confirm New Password') }}</label>
                <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                @if ($errors->has('password_confirmation'))
                    <span class="form-error">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>

            <button type="submit" class="btn-primary mt-4">
                {{ __('Reset Password') }}
            </button>
        </form>
    </div>
</x-guest-layout>
