@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{asset('css/list2.css')}}">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Szkoła') }}</div>

                <div class="card-body">
                    <form method="POST" action="/szkola">
                        @csrf

                        <div class="row mb-3">
    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nazwa') }}</label>

    <div class="col-md-6">
        <input id="name" list="schools" type="search" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="first_name" autofocus>
        <datalist id="schools">
            @foreach($schools as $school)
                <option value="{{ $school->name }}">
            @endforeach
        </datalist>
    </div>
</div>

                    

                    

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Zapisz') }}
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
<div class="footer">
    <p class="footer-text">@Sławek&Natan Company</p>
</div>
