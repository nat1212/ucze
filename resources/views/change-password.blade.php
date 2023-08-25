@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{asset('css/list2.css')}}">
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Zmień hasło') }}</div>

                    <form action="{{ route('update-password') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @elseif (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="oldPasswordInput" class="form-label">Stare hasło</label>
                                <input name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput"
                                    placeholder="Stare hasło">
                                <div class="form-check mt-2">
                                    <input type="checkbox" class="form-check-input" id="showOldPassword">
                                    <label class="form-check-label" for="showOldPassword">Pokaż hasło</label>
                                </div>
                                @error('old_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="newPasswordInput" class="form-label">Nowe hasło</label>
                                <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput"
                                    placeholder="Nowe hasło">
                                    <div class="form-check mt-2">
                                        <input type="checkbox" class="form-check-input" id="showNewPassword">
                                        <label class="form-check-label" for="showNewPassword">Pokaż hasło</label>
                                    </div>
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                            <label for="confirmNewPasswordInput" class="form-label">Potwierdź nowe hasło</label>
                            <input name="new_password_confirmation" type="password" class="form-control" id="confirmNewPasswordInput" placeholder="Potwierdź nowe hasło">
                            <div class="form-check mt-2">
                                <input type="checkbox" class="form-check-input" id="showConfirmNewPassword">
                                <label class="form-check-label" for="showConfirmNewPassword">Pokaż hasło</label>
                            </div>
                        </div>

                        </div>

                        <div class="card-footer">
                            <button class="btn btn-primary">Zapisz</button>
                            <a href="{{ route('home') }}" class="btn btn-primary">Wróć</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
    <p class="footer-text">@Sławek&Natan Company</p>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const showOldPasswordCheckbox = document.getElementById("showOldPassword");
        const oldPasswordInput = document.getElementById("oldPasswordInput");

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
        const newPasswordInput = document.getElementById("newPasswordInput");

        showNewPasswordCheckbox.addEventListener("change", function () {
            if (showNewPasswordCheckbox.checked) {
                newPasswordInput.type = "text";
            } else {
                newPasswordInput.type = "password";
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const showConfirmNewPasswordCheckbox = document.getElementById("showConfirmNewPassword");
        const confirmNewPasswordInput = document.getElementById("confirmNewPasswordInput");

        showConfirmNewPasswordCheckbox.addEventListener("change", function () {
            if (showConfirmNewPasswordCheckbox.checked) {
                confirmNewPasswordInput.type = "text";
            } else {
                confirmNewPasswordInput.type = "password";
            }
        });
    });
</script>
@endsection
