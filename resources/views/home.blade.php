@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <a href="change-password    ">Zmień hasło</a>
                    <h4>Lista twoich wydarzeń oraz kto ma dostęp:</h4>
                    @if(isset($results))
                        @foreach ($results as $result)
                            <p>Event id: {{ $result->id }}</p>
                            <p>Event Name: {{ $result->name }}</p>
                            <p>Event Details Title: {{ $result->title }}</p>
                            <a href="/leave/{{ $result->id }}"><button>Wypisz się</button></a>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
