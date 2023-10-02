@extends('layouts.app')
@section('styles')

<link rel="stylesheet" href="{{asset('css/footer.css')}}">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Zapis grupowy na wydarzenie:')}}   {{$event_details_title}} </div>

                <div class="card-body">
                <div class="des2">Uwaga!</div>
                <div class="des">W tym zapisie grupowym potrzebne jest tylko podanie ilości osób które będą obecne na wydarzeniu!</div>
              <div class="container2">
    <div class="center-align">
        <label for="number_input">Dostępne miejsca:</label>
        <span id="available_seats">{{ $seats }} </span>
    </div>
    <div class="center-align">
        <div class="input-group">
        <form method="POST" action="/zapisznr">
                                @csrf

        <input id="number_input" class="form-control" type="number" name="number_of_people" placeholder="Dodaj osoby" min="1" oninput="validateNumber()">
                  </div>
      
    </div>
    @if ($errors->any())
            <div class="alert ">
                <ul>
                    @foreach ($errors->all() as $error)
                       {{ $error }}
                    @endforeach
                </ul>
            </div>
        @endif
    <div id="update-message2" class="alert" style="display: none;"></div>
</div>
         
                   
                       
                        <input type="hidden" name="event_details_id" value="{{ $event_details_id }}">

                        <div class="row mb-0 mt-4">
                            <div class="col-md-6 offset-md-5    ">
                            <button type="submit" class="btn btn-primary" id="addButton" disabled >
                                    {{ __('Dodaj') }}
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




<script>

function validateNumber() {
    var numberOfPeople = parseInt(document.getElementById('number_input').value);
    var availableSeats = parseInt(document.getElementById('available_seats').textContent);
    var updateMessage = document.getElementById('update-message2');
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


</script>
@endsection