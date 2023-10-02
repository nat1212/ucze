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
                                <button data-id="{{ $event_id }}" class="btn btn-danger dele">Usuń liste</button>
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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $('.dele').click(function() {
        var eventId = $(this).data("id");
        var confirmed = window.confirm("Czy na pewno chcesz usunąć listę?");
        if (confirmed) {
            $.ajax({
                method: "DELETE",
                url: "http://szkola.test/listnr-nr/" + eventId,
                headers: {
                    'X-CSRF-TOKEN': csrfToken 
                },
                success: function(data) {
                    if (data.success) {
            
      
                    } else {
               
                        alert("Wystąpił błąd: " + data.message);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                
                    alert("Wystąpił błąd podczas żądania: " + textStatus);
                }
            });
        }
    });
</script>



@endsection