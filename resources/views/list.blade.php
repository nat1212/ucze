@extends('layouts.app')
@section('styles')

<link rel="stylesheet" href="{{asset('css/footer2.css')}}">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">{{ __('Edycja grupowa na wydarzenie:')}}   {{$event_details_title}} </div>

<div class="card-body">
<div class="container2">
<div class="center-align">
<label for="number_input">Dostępne miejsca:</label>
<span id="available_seats">{{ $seats }}</span>
</div>
<div class="center-align">
<div class="input-group">
<input id="number_input" class="form-control" type="number" placeholder="Dodaj nowe osoby" min="1">
<div class="input-group-append">
<button onclick="addInputss()" class="btn-spacing">Dodaj</button>
</div>
</div>

</div>
<div id="update-message2" class="alert" style="display: none;"></div>
</div>
                    <form method="POST" action="/edit">
                        @csrf

                        <div class="row mb-3">


    <div  class="row" id="dynamic-inputs" style="margin: 15px;">


    @foreach($names as $i => $participant)
    <div style="margin-bottom:15px;" class="col-md-5">
        <input class="form-control" type="text" name="first{{ $i }}" value="{{ $participant->first_name }}" placeholder="Imię" autocomplete="nazwa1" autofocus>
    </div>
    <div class="col-md-5">
        <input class="form-control" type="text" name="last{{ $i }}" value="{{ $participant->last_name }}" placeholder="Nazwisko" autocomplete="nazwa2" autofocus>
    </div>
    <div class="col-md-1" >
        <button data-id="{{ $participant->id }}" class="btn btn-danger des">Usuń</button>
    </div>
@endforeach
    </div>
</div>
                       
                        <input type="hidden" name="id" value="{{ $event_id }}">
                       
                        <input type="hidden" name="event_details_id" value="{{ $event_details_id }}">

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-5    ">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Edytuj') }}
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
  let counter = 0; 

function addInputss() {
    const numberInput = document.getElementById("number_input");
    const numberOfInputsToAdd = parseInt(numberInput.value);

    const updateMessage = document.getElementById('update-message2');
    const availableSeatsElement = document.getElementById('available_seats');
    const participantInputs = document.getElementById('participantInputs'); 

    if (isNaN(numberOfInputsToAdd) || numberOfInputsToAdd <= 0) {
        updateMessage.textContent = "Proszę wprowadzić poprawną liczbę większą od zera.";
        updateMessage.style.display = 'block';

        setTimeout(function () {
            updateMessage.style.display = 'none';
        }, 3000);

        return;
    }

    const currentAvailableSeats = parseInt(availableSeatsElement.textContent);

    if (numberOfInputsToAdd > currentAvailableSeats) {
        updateMessage.textContent = "Nie można dodać więcej osób niż dostępnych miejsc.";
        updateMessage.style.display = 'block';

        setTimeout(function () {
            updateMessage.style.display = 'none';
        }, 3000);

        return;
    }

    const newAvailableSeats = currentAvailableSeats - numberOfInputsToAdd;
    availableSeatsElement.textContent = newAvailableSeats;

    numberInput.value = "";

    for (let i = 0; i < numberOfInputsToAdd; i++) {
        counter++;

        const parentDiv = document.querySelector(".row.mb-3"); 

        const divRow = document.createElement("div");
        divRow.className = "row mb-3"; 
        const divCol1 = document.createElement("div");
        divCol1.className = "col-md-1 numeracja-label"; 

        const indexLabel = document.createElement("label");
        indexLabel.textContent = counter + "."; 

        divCol1.appendChild(indexLabel);

        const divCol2 = document.createElement("div");
        divCol2.className = "col-md-5";

        const firstNameInput = document.createElement("input");
        firstNameInput.className = "form-control @error('city') is-invalid @enderror";
        firstNameInput.type = "text";
        firstNameInput.name = "first_name" + counter;
        firstNameInput.placeholder = "Imię";

        const divCol3 = document.createElement("div");
        divCol3.className = "col-md-5";

        const lastNameInput = document.createElement("input");
        lastNameInput.className = "form-control @error('city') is-invalid @enderror";
        lastNameInput.type = "text";
        lastNameInput.name = "last_name" + counter;
        lastNameInput.placeholder = "Nazwisko";

        divCol2.appendChild(firstNameInput);
        divCol3.appendChild(lastNameInput);

        divRow.appendChild(divCol1);
        divRow.appendChild(divCol2);
        divRow.appendChild(divCol3);

        parentDiv.appendChild(divRow); 
    }
}


     
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
          
            $('.des').click(function() {
                var userId = $(this).data("id");
                $.ajax({
                    method: "DELETE",
                    url: "http://szkola.test/list/" + userId,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken 
                    }
                })
               .done(function (response) {



        const currentAvailableSeats = parseInt(document.getElementById('available_seats').textContent);
        const newAvailableSeats = currentAvailableSeats + 1; 

        window.location.reload();

        
    })

    
});

</script>
@endsection