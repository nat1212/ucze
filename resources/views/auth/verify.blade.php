@extends('layouts.app')
@section('styles')

<link rel="stylesheet" href="{{asset('css/foot.css')}}">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Zweryfikuj swój adres email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Na Twój adres e-mail został wysłany nowy link weryfikacyjny.') }}
                        </div>
                    @endif

                    {{ __('Przed kontynuowaniem sprawdź, czy w skrzynce e-mail znajduje się link weryfikacyjny.') }}
               
                    <div class="" >
                    {{ __('Jeśli nie otrzymałeś wiadomości e-mail') }},
                        </div>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Kliknij tutaj, aby wysłać nowy') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <p class="footer-text">@Sławek&Natan Company</p>
    </div>



  
@endsection
