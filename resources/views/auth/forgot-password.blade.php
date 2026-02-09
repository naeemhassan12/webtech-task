<x-guest-layout>
    <div class="auth-card animate-fade-in">
        <div class="auth-logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-white" />
            </a>
        </div>
        
        <h2 class="auth-title">Reset Password</h2>
        <p class="auth-subtitle">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}</p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@company.com" />
                @if ($errors->has('email'))
                    <span class="form-error">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <button type="submit" class="btn-primary mt-4">
                {{ __('Email Password Reset Link') }}
            </button>
            
            <div class="auth-footer text-center justify-center mt-6">
                <a href="{{ route('login') }}" class="auth-link">Back to Login</a>
            </div>
        </form>
    </div>
</x-guest-layout>
