  <x-guest-layout>
    <div class="auth-card animate-fade-in">
        <div class="auth-logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-white" />
            </a>
        </div>
        
        <h2 class="auth-title">Welcome Back</h2>
        <p class="auth-subtitle">Sign in to access your dashboard</p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert-success mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@company.com" />
                @if ($errors->has('email'))
                    <span class="form-error">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                @if ($errors->has('password'))
                    <span class="form-error">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mb-6">
                <label for="remember_me" class="form-checkbox">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>{{ __('Remember me') }}</span>
                </label>
                
                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <button type="submit" class="btn-primary">
                {{ __('Sign In') }}
            </button>
            
            <div class="auth-footer text-center justify-center mt-6">
                <span class="text-gray-400 text-sm">Don't have an account? </span>
                <a href="{{ route('register') }}" class="auth-link ml-1">Sign up</a>
            </div>
        </form>
    </div>
</x-guest-layout>
