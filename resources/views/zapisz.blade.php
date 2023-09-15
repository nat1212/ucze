@extends('layouts.app')
@section('styles')

<link rel="stylesheet" href="{{asset('css/footer.css')}}">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __(' Zapis grupowy na wydarzenie:') }}   {{ $event_details_title }}</div>

                <div class="card-body">
                <div class="row">
                       <label>Wolne miejsca = {{ $seats }}</label>
                    </div>  
                <div class="row">
                        <div class="col-md-6">
                            <input id="number_input" class="form-control" type="number" placeholder="Liczba">
                        </div>
                        <div class="col-md-6">
                            <button onclick="addInputs()">Dodaj</button>
                        </div>
                    </div>
                    <form method="POST" action="/zapisz">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Imie i nazwisko') }}</label>

                            <div class="row" id="dynamic-inputs" style="margin-bottom:15px;">
                            <div class="col-md-6">
                                <input id="first_name1"  class="form-control @error('city') is-invalid @enderror" type="text"  name="first_name1" value="{{ session('name') }}" placeholder="Imię"  autocomplete="nazwa1" autofocus>
                            </div>
                            <div class="col-md-6">
                                <input id="last_name1" class="form-control @error('city') is-invalid @enderror" type="text"  name="last_name1" value="{{ session('name') }}" placeholder="Nazwisko"  autocomplete="nazwa2" autofocus>
                            </div>
                        </div>

                        </div>
                       
                   
                       
                        <input type="hidden" name="event_details_id" value="{{ $event_details_id }}">

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-5    ">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Stwórz') }}
                                </button>
                                <a href="{{ route('event.list') }}" class="btn btn-primary">
                                    {{ __('Wróć') }}
                                </a>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <p class="footer-text">@Sławek&Natan Company</p>
    </div>
@endsection
@section('javascript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const firstNameInputs = document.querySelectorAll("input[name^='first_name']");
        const lastNameInputs = document.querySelectorAll("input[name^='last_name']");
        
        firstNameInputs.forEach(function(input, index) {
            input.addEventListener("input", function() {
                countParticipants();
            });
        });

        lastNameInputs.forEach(function(input, index) {
            input.addEventListener("input", function() {
                countParticipants();
            });
        });

        function countParticipants() {
            const totalParticipants = Array.from(firstNameInputs).filter(input => input.value.trim() !== "").length;
            const numberInput = document.querySelector("input[name='number_of_people']");
            numberInput.value = totalParticipants;
           
        }
        countParticipants();
    });
</script>
<script>
    let counter = 1;

    function addInputs() {
    const numberInput = document.getElementById("number_input");
    const numberOfInputsToAdd = parseInt(numberInput.value);

    if (isNaN(numberOfInputsToAdd) || numberOfInputsToAdd <= 0) {
        alert("Proszę wprowadzić poprawną liczbę większą od zera.");
        return;
    }

    for (let i = 0; i < numberOfInputsToAdd; i++) {
        counter++;

        const parentDiv = document.querySelector(".row.mb-3"); // Znajdź div o klasie "row mb-3"

        const divRow = document.createElement("div");
        divRow.className = "row mb-3"; // Dodaj klasę "mb-3" dla marginesu na dół

        const divCol1 = document.createElement("div");
        divCol1.className = "col-md-6";

        const firstNameInput = document.createElement("input");
        firstNameInput.className = "form-control @error('city') is-invalid @enderror";
        firstNameInput.type = "text";
        firstNameInput.name = "first_name" + counter;
        firstNameInput.placeholder = "Imię";
        

        divCol1.appendChild(firstNameInput);

        const divCol2 = document.createElement("div");
        divCol2.className = "col-md-6";

        const lastNameInput = document.createElement("input");
        lastNameInput.className = "form-control @error('city') is-invalid @enderror";
        lastNameInput.type = "text";
        lastNameInput.name = "last_name" + counter;
        lastNameInput.placeholder = "Nazwisko";
        

        divCol2.appendChild(lastNameInput);

        divRow.appendChild(divCol1);
        divRow.appendChild(divCol2);

        parentDiv.appendChild(divRow); // Dodaj divRow do diva o klasie "row mb-3"
    }
}

</script>
@endsection