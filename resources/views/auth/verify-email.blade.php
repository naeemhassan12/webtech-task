<x-guest-layout>
    <div class="auth-card animate-fade-in">
        <div class="auth-logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-white" />
            </a>
        </div>
        
        <h2 class="auth-title">Verify Email</h2>
        <p class="auth-subtitle">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?') }}
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-400 bg-green-900/30 p-3 rounded-lg border border-green-800">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-6 flex flex-col gap-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary w-full">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="auth-link w-full text-center text-sm">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
