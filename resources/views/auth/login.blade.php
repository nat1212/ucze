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
                <div class="card-header">{{ __('Logowanie') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
    @if($errors->any())
    <div class="alert alert-danger error-message">
            @foreach($errors->all() as $error)
                {{ $error }}
            @endforeach
    </div>
     @endif
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                             
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Hasło') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                           
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Zapamiętaj mnie') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Zaloguj') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Zapomniałeś hasła?') }}
                                    </a>
                                @endif
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
    }, 3000);
});
</script>
<script>


setTimeout(function() {
        var errorMessages = document.getElementsByClassName('error-message');
        for (var i = 0; i < errorMessages.length; i++) {
            errorMessages[i].style.display = 'none';
        }
    }, 5000); 
    </script>
@endsection
