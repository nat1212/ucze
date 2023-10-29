@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{asset('css/szkola.css')}}">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Szkoła') }}</div>

                <div class="card-body">
                <form action="/szkola-edit" method="POST">
                        @csrf

                        <div class="row mb-3">
    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nazwa') }}</label>

    <div class="col-md-6">
    <input id="name" list="schools" type="search" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="first_name" autofocus>
    <datalist id="schools">
        @foreach($schools as $school)
            <option value="{{ $school->name }} ul.{{ $school->street }} {{ $school->zip_code }}">
        @endforeach
    </datalist>
</div>
</div>

                    

                    

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Zapisz') }}
                                </button>

                                
                                <a style="margin: 10px 0;" href="{{ route('home') }}" class="btn btn-primary">Anuluj</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

const inputField = document.getElementById('name');
const datalist = document.getElementById('schools');
const options = Array.from(datalist.getElementsByTagName('option'));

inputField.addEventListener('input', function () {
    const inputValue = inputField.value.toLowerCase();


    datalist.innerHTML = '';


    options.forEach(option => {
        if (option.value.toLowerCase().includes(inputValue)) {
            datalist.appendChild(option.cloneNode(true));
        }
    });
});

inputField.addEventListener('change', function () {

    datalist.innerHTML = '';
});

</script>





@endsection
<div class="footer">
    <p class="footer-text">@Sławek&Natan Company</p>
</div>
