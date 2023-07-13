@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dodaj kumpla') }}</div>

                <div class="card-body">
                    <form method="POST" action="/addMember">
                        @csrf

                        <div class="row mb-3">
                            <label for="date_start" class="col-md-4 col-form-label text-md-end">{{ __('Data początku uprawnień') }}</label>

                            <div class="col-md-6">
                                <input id="date_start" type="date" class="form-control" name="date_start"  required  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="date_end" class="col-md-4 col-form-label text-md-end">{{ __('Data zakończenia uprawnień') }}</label>

                            <div class="col-md-6">
                                <input id="date_end" type="date" class="form-control" name="date_end"  required  autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="users_role_dictionary_id" class="col-md-4 col-form-label text-md-end">{{ __('Rola') }}</label>

                            <div class="col-md-6">
                            <select id="role" class="form-control" name="users_role_dictionary_id" required autofocus>
                                @foreach($roles as $key => $role)
                                @if(!$key == 0)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div id="role-description"></div>
                        </div>
                        </div>
                        

                        <div class="row mb-3">
                           

                            <div class="col-md-6">
                            <input id="events_id" type="hidden" value="{{ $event }}" class="form-control" name="events_id" required  autofocus>                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="users_id" class="col-md-4 col-form-label text-md-end">{{ __('User') }}</label>

                            <div class="col-md-6">
                            <select id="status" class="form-control" name="users_id" required autofocus>
                                @foreach($users as $key => $user)
                                    @if(!$key == 0)
                                    <option value="{{ $user->id }}">{{ $user->email }}</option>
                                    @endif
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <input type="hidden" name="additional_property" value="1" />
                       

                       
                       

                      

                       

                        
                         
                        <div class="row mb-0">
                           
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Stwórz') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('javascript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>$(document).ready(function() {
    $('#role').change(function() {
        var roleId = $(this).val();
        var roleDescription = '';

        // Tutaj możesz dodać warunki, które ustalą odpowiedni opis w zależności od wartości roleId
        if (roleId === '1') {
            roleDescription = 'Opis roli 1';
        } else if (roleId === '2') {
            roleDescription = 'Możliwa edycja/dodanie/usunęcie pod wydarzenia.Nie możliwe usunięcie wydarzenia oraz dodanie innych uczestników';
        } else if (roleId === '3') {
            roleDescription = 'Nie możliwa edycja głównego wydarzenia ani usunięcien';
        }
        // Dodaj więcej warunków, jeśli masz więcej ról

        $('#role-description').text(roleDescription);
    });
});</script>
@endsection
