@extends('layouts.app')
@section('styles')

<link rel="stylesheet" href="{{asset('css/footer3.css')}}">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">{{ __('Edycja grupowa na wydarzenie:')}}   {{$event_details_title}} </div>

<div class="card-body">
<label for="number_input1">Zapisane przez ciebie osoby na to wydarzenie:  </label>
<span id="available_seats2">{{ $number_of_people }}</span>
<br>
@if (strtotime($date) > strtotime('now'))
<label for="number_input55">Dostępne miejsca:</label> <span id="available_seats">{{ $seats }}</span>
<br>



   

<form method="POST" action="/edit2">
                                @csrf
                                <label for="Dop">Liczba osób które chcesz dopisać:</label>
<input id="number_input" class="form-control" type="number" placeholder="Dodaj nowe osoby" name="number_of_peoplee"  min = "1" oninput="validateNumber()">
<button type="submit" class="btn btn-primary" id="addButton" disabled>  {{ __('Dodaj') }}  </button>


<div id="update-message1" class="alert" style="display: none;"></div>

                       
                        <input type="hidden" name="id" value="{{ $event_id }}">
                       
                        <input type="hidden" name="event_details_id" value="{{ $event_details_id }}">

                        </form>


<form method="POST" action="/edit3">
                                @csrf
                                <label for="Usu">Liczba osób które chcesz usunąć:</label>
<input id="number_input2" class="form-control" type="number" placeholder="Usuń osoby" name="delete_people" min = "1" oninput="validateNumber2()" >
<button type="submit" class="btn btn-primary" id="addButton2"disabled>
                                    {{ __('Usuń') }}
                                </button>

                                <div id="update-message2" class="alert" style="display: none;"></div>
                                
@if ($errors->any())
            <div class="alert2 ">
                <ul>
                    @foreach ($errors->all() as $error)
                       {{ $error }}
                    @endforeach
                </ul>
            </div>
        @endif

                      
                        <input type="hidden" name="id" value="{{ $event_id }}">
                       
                        <input type="hidden" name="event_details_id" value="{{ $event_details_id }}">

                        </form>
                        @endif
                        <div class="row mb-0" style="margin-top: 30px;">
                            <div class="col-md-6 offset-md-5 ">
                                <a href="{{ route('home') }}" class="btn btn-primary">
                                    {{ __('Anuluj') }}
                                </a>
                                @if (strtotime($date) > strtotime('now'))
                                <button data-id="{{ $event_id }}" class="btn btn-danger dele">Usuń liste</button>
                                @endif
                            </div>
                            
                        </div>
               
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</div>
<div class="footer">
    <p class="footer-text">@Sławek&Natan Company</p>
    </div>

    <div id="leave-dialog" class="dialog"  style="display: none;">
    <div class="dialog-content">
        <p>Czy na pewno chesz usunąć grupę?</p>
        <button id="confirm-leave-button">Tak</button>
        <button id="cancel-leave-button">Nie</button>
    </div>
</div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <script>
   var csrfToken = $('meta[name="csrf-token"]').attr('content');

   $('.dele').click(function() {
       var eventId = $(this).data("id");

       $('#leave-dialog').show();

       $('#confirm-leave-button').click(function() {
           $('#leave-dialog').hide();
           $.ajax({
               method: "DELETE",
               url: "http://szkola.test/listnr-nr/" + eventId,
               headers: {
                   'X-CSRF-TOKEN': csrfToken
               },
               complete: function() {
                   window.location.href = '/home';
               }
           });
       });

       $('#cancel-leave-button').click(function() {
           $('#leave-dialog').hide();
       });
   });

</script>





<script>
function validateNumber() {
    var numberOfPeople = parseInt(document.getElementById('number_input').value);
    var availableSeats = parseInt(document.getElementById('available_seats').textContent);
    var updateMessage = document.getElementById('update-message1');
    var addButton = document.getElementById('addButton'); 

    if (numberOfPeople <= 0 || numberOfPeople > availableSeats) {
        updateMessage.textContent = 'Liczba osób musi być większa niż 0 i nie może przekroczyć dostępnej liczby miejsc.';
        updateMessage.style.color = 'red';
        updateMessage.style.display = 'block';
        addButton.disabled = true;
    } else {
        updateMessage.style.display = 'none';
        addButton.disabled = false;
    }
}
function hideErrors() {
    var alertElement = document.querySelector('.alert');
    if (alertElement) {
        setTimeout(function () {
            alertElement.style.display = 'none';
        }, 2000); 
    }
}

function validateNumber2() {
    var deletePeople = parseInt(document.getElementById('number_input2').value);
    var numberOfPeople = parseInt(document.getElementById('available_seats2').textContent);
    var updateMessage2 = document.getElementById('update-message2');
    var addButton2 = document.getElementById('addButton2');

    if (deletePeople <= 0 || deletePeople > numberOfPeople) {
        updateMessage2.textContent = 'Liczba osób musi być większa niż 0 i nie może przekroczyć liczby zapisanych miejsc.';
        updateMessage2.style.color = 'red';
        updateMessage2.style.display = 'block';
        addButton2.disabled = true;
    } else {
        updateMessage2.style.display = 'none';
        addButton2.disabled = false;
    }
}

function hideErrors() {
        var alertElements = document.querySelectorAll('.alert2'); 
        alertElements.forEach(function(alertElement) {
            setTimeout(function () {
                alertElement.style.display = 'none';
            }, 3000); 
        });
    }

    
    window.onload = function () {
        hideErrors();
    };

    document.addEventListener("DOMContentLoaded", function() {
        const preventEnterFields = document.querySelectorAll("input[type='number']");

        preventEnterFields.forEach(function(field) {
            field.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                }
            });
        });
    });

</script>



@endsection