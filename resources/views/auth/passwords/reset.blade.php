@extends('layouts.app')
@section('styles')

<link rel="stylesheet" href="{{asset('css/loading.css')}}">
<link rel="stylesheet" href="{{asset('css/foot.css')}}">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Hasła') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Adres Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Hasło') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Potwierdź hasło') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Zresetuj hasło') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <p class="footer-text">@Sławek&Natan Company</p>
    </div>
<div id="loading" class="loading">
        <div class="loading-spinner">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Przetwarzanie...</span>
            </div>
            <p>Proszę czekać...</p>
        </div>
    </div>
    </div>
    <div id="loading-overlay" class="loading-overlay"></div>

    <script>
const registerForm = document.querySelector("form");
const loadingSpinner = document.getElementById("loading");
const loadingOverlay = document.getElementById("loading-overlay");

registerForm.addEventListener("submit", function () {
    loadingOverlay.style.display = "block";
    loadingSpinner.style.display = "block";

    setTimeout(function () {
        loadingOverlay.style.display = "none";
        loadingSpinner.style.display = "none";
    }, 7000);
});

    </script>
@endsection
