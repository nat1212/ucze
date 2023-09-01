@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset('css/list3.css')}}">
@endsection

@section('content')

<div class="row">
        <div class="text">
        <h1>Zapis grupowy na wydarzenie: (info->title)</h1>
        </div>
    </div>
<div class="container">

<div id="group">
    <form action="{{ route('add_group_submit') }}" method="POST" id="group-form">
    @csrf
    <div id="error-message" style="color: red;"></div>
<span id="available-seats-info">Dostępne miejsca: (info->number_seats) </span>

    <input type="number" id="person-count-input" placeholder="Liczba osób" min="1" value="1">
    <button type="button" id="add-person-button">Dodaj osobę</button>

    <div id="group-persons">

    </div>

    <button type="button" id="cancel-button" onclick="redirectReturn()">Wróć</button>
    <button type="submit">Zapisz grupę</button>
</form>
</div>

</div>

<div class="footer">
    <p class="footer-text">@Sławek&Natan Company</p>
    </div>


<script>
  
  document.addEventListener('DOMContentLoaded', function() {
    var addPersonButton = document.getElementById('add-person-button');
    var groupPersonsDiv = document.getElementById('group-persons');
    var personCountInput = document.getElementById('person-count-input');
    var personCounter = 0;

    addPersonButton.addEventListener('click', function() {
        var count = parseInt(personCountInput.value);
        personCountInput.value = "1";

        for (var i = 0; i < count; i++) {
            var personDiv = document.createElement('div');
            personDiv.className = 'person';

          
            personCounter++;
            var personNumber = personCounter;

            var firstNameLabel = document.createElement('label');
            firstNameLabel.textContent = personNumber + ':';
            var firstNameInput = document.createElement('input');
            firstNameInput.type = 'text';
            firstNameInput.name = 'first_name[]';
            firstNameInput.required = true;

            var lastNameLabel = document.createElement('label');
            lastNameLabel.textContent = 'Nazwisko:';
            var lastNameInput = document.createElement('input');
            lastNameInput.type = 'text';
            lastNameInput.name = 'last_name[]';
            lastNameInput.required = true;

            var deletePersonButton = document.createElement('button');
            deletePersonButton.type = 'button';
            deletePersonButton.className = 'delete-person-button';
            deletePersonButton.textContent = 'Usuń';

            deletePersonButton.addEventListener('click', function() {
            
                var personToRemove = this.parentElement;

          
                if (personToRemove) {
                    personToRemove.remove();
               
                    personCounter--;
             
                    updatePersonNumbers();
                }
            });

            personDiv.appendChild(firstNameLabel);
            personDiv.appendChild(firstNameInput);
            personDiv.appendChild(lastNameLabel);
            personDiv.appendChild(lastNameInput);
            personDiv.appendChild(deletePersonButton);

            groupPersonsDiv.appendChild(personDiv);
        }
    });

    var groupForm = document.getElementById('group-form');
    var errorMessage = document.getElementById('error-message');

    groupForm.addEventListener('submit', function(event) {
        var persons = document.querySelectorAll('.person');

        if (persons.length === 0) {
            event.preventDefault();
            errorMessage.textContent = 'Dodaj co najmniej jedną osobę do grupy przed zapisem.';

            setTimeout(function() {
                errorMessage.textContent = '';
            }, 2000);
        }
    });

    function updatePersonNumbers() {
        var persons = document.querySelectorAll('.person');
        persons.forEach(function(person, index) {
            var personNumber = index + 1;
            person.querySelector('label').textContent = personNumber + ':';
        });
    }
});



function redirectReturn(eventDetailsId) {
    window.location.href = "{{ route('event.list') }}";
}
</script>

@endsection
