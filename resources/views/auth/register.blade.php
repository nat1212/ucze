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
                <div class="card-header">{{ __('Rejestracja') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('Imię') }}</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Nazwisko') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                       
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                <div class="form-check mt-2">
                                    <input type="checkbox" class="form-check-input" id="showOldPassword">
                                    <label class="form-check-label" for="showOldPassword">Pokaż hasło</label>
                                </div>
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
                                <div class="form-check mt-2">
                                        <input type="checkbox" class="form-check-input" id="showNewPassword">
                                        <label class="form-check-label" for="showNewPassword">Pokaż hasło</label>
                                </div>
                                <div id="passwordMatchError" class="text-danger"></div>
                            </div>
                            
                        </div>
                        <div class="row mb-3">
                            <label for="sex" class="col-md-4 col-form-label text-md-end">{{ __('Płeć') }}</label>

                            <div class="col-md-6">
                                <select id="sex" class="form-control" name="sex" required autofocus>
                                    <option value="m">Mężczyzna</option>
                                    <option value="k">Kobieta</option>
                                    <option value="n">Nie chcę podawać</option>

                                </select>

                                
                            </div>
                        </div>
                       
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-6">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Zarejestruj') }}
                                </button>
                            </div>
                        </div>
                    </form>
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
    document.addEventListener("DOMContentLoaded", function () {
        const showOldPasswordCheckbox = document.getElementById("showOldPassword");
        const oldPasswordInput = document.getElementById("password");

        showOldPasswordCheckbox.addEventListener("change", function () {
            if (this.checked) {
                oldPasswordInput.type = "text";
            } else {
                oldPasswordInput.type = "password";
            }
        });
    });


    document.addEventListener("DOMContentLoaded", function () {
        const showNewPasswordCheckbox = document.getElementById("showNewPassword");
        const newPasswordInput = document.getElementById("password-confirm");

        showNewPasswordCheckbox.addEventListener("change", function () {
            if (showNewPasswordCheckbox.checked) {
                newPasswordInput.type = "text";
            } else {
                newPasswordInput.type = "password";
            }
        });
    });

    const registerForm = document.querySelector("form");
const loadingSpinner = document.getElementById("loading");
const loadingOverlay = document.getElementById("loading-overlay");

registerForm.addEventListener("submit", function () {
    loadingOverlay.style.display = "block";
    loadingSpinner.style.display = "block";

    setTimeout(function () {
        loadingOverlay.style.display = "none";
        loadingSpinner.style.display = "none";
    }, 10000);
});



document.addEventListener("DOMContentLoaded", function () {
    const showConfirmNewPasswordCheckbox = document.getElementById("showNewPassword");
    const confirmNewPasswordInput = document.getElementById("password-confirm");
    const newPasswordInput = document.getElementById("password");
    const passwordMatchError = document.getElementById("passwordMatchError");

    showConfirmNewPasswordCheckbox.addEventListener("change", function () {
        if (showConfirmNewPasswordCheckbox.checked) {
            confirmNewPasswordInput.type = "text";
        } else {
            confirmNewPasswordInput.type = "password";
        }
    });

    newPasswordInput.addEventListener("input", function () {

        if (newPasswordInput.value !== confirmNewPasswordInput.value) {
            passwordMatchError.textContent = "Hasła nie pasują do siebie.";
        } else {
            passwordMatchError.textContent = "";
        }
    });

    confirmNewPasswordInput.addEventListener("input", function () {
    
        if (newPasswordInput.value !== confirmNewPasswordInput.value) {
            passwordMatchError.textContent = "Hasła nie pasują do siebie.";
        } else {
            passwordMatchError.textContent = "";
        }
    });
});
    </script>
@endsection
