@extends('layouts.guest')

@section('content')
<div
    class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6 col-xxl-3">
                <div class="card mb-0">
                    <div class="card-body">
                        <a href="{{ route('dashboard') }}" class="text-nowrap logo-img text-center d-block py-3 w-100">
                            <img src="{{ asset('assets/images/logos/dark-logo.svg') }}" width="180" alt="Logo">
                        </a>
                        <p class="text-center">Your Social Campaigns</p>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4 text-center alert alert-info" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required autocomplete="current-password">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input primary" type="checkbox" name="remember"
                                        id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark" for="remember">
                                        Remember this Device
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                <a class="text-primary fw-bold" href="{{ route('password.request') }}">Forgot
                                    Password?</a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign
                                In</button>

                            <!-- Register Link -->
                            @if (Route::has('register'))
                            <div class="d-flex align-items-center justify-content-center">
                                <p class="fs-4 mb-0 fw-bold">New to Modernize?</p>
                                <a class="text-primary fw-bold ms-2" href="{{ route('register') }}">Create an
                                    account</a>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#password').after('<button type="button" class="btn btn-sm toggle-password">Show</button>');
        $('.toggle-password').click(function() {
            let input = $('#password');
            input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
            $(this).text($(this).text() === 'Show' ? 'Hide' : 'Show');
        });
</script>
@endsection