<x-guest-layout>
    <div class="auth-card animate-fade-in">
        <div class="auth-logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-white" />
            </a>
        </div>
        
        <h2 class="auth-title">Create Account</h2>
        <p class="auth-subtitle">Join us and start your journey</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">{{ __('Full Name') }}</label>
                <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe" />
                @if ($errors->has('name'))
                    <span class="form-error">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="name@company.com" />
                @if ($errors->has('email'))
                    <span class="form-error">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                @if ($errors->has('password'))
                    <span class="form-error">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                @if ($errors->has('password_confirmation'))
                    <span class="form-error">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>

            <button type="submit" class="btn-primary mt-4">
                {{ __('Create Account') }}
            </button>
            
            <div class="auth-footer text-center justify-center mt-6">
                <span class="text-gray-400 text-sm">Already have an account? </span>
                <a href="{{ route('login') }}" class="auth-link ml-1">Sign in</a>
            </div>
        </form>
    </div>
</x-guest-layout>

