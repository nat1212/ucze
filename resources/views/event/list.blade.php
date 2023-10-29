@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset('css/list.css')}}">
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-8 text-center">
        <h1>AKTUALNE WYDARZENIA NA UCZELNI</h1>
    </div>
    </div>


    @if($errors->any())
    <div class="alert alert-danger error-message">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
     @endif
                   
     @if (session('status'))
        <div id="status-message" class="alert alert-success" role="alert">
        {{ session('status') }}
        </div>
      @endif


      <div class="row3">
    <div class="col-10">
        <form action="{{ route('events.search') }}" method="GET" class="d-flex align-items-center" >
            <input type="text" class="form-control" name="search_name" id="search_name" placeholder="Szukaj po nazwie" value="" autocomplete="off">
            <button type="submit" class="btn btn-primary">Szukaj</button>
        </form>
        @if ($searchMessage)
            <p id="searchMessage">{{ $searchMessage }}</p>
        @endif
    </div>
</div>

    @foreach ($events as $event)
    @if (strtotime($event->date_start_publi) < strtotime('now') && strtotime($event->date_end_publi) > strtotime('now'))
    <div class="row">
        <div class="table-wrapper ">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="name1">{{ $event->name }} ({{$event->shortcut}})</th>
                    </tr>
                </thead>
            </table>
            <div>
            <div class="des-row">
            <div class="left-content">
            
            <div class="des-row55">
    <p scope="col" class="des">Rozpoczęcie:</p>
    <p scope="col" class="des2">{{ $event->date_start->format('d-m-Y')}} godz.{{ $event->date_start->format('H:i') }}</p>
</div>

<div class="des-row55">
    <p scope="col" class="des">Zakończenie:</p>
    <p scope="col" class="des2">{{ $event->date_end->format('d-m-Y') }} godz.{{ $event->date_end->format('H:i') }}</p>
</div>

    
            <div class="des-row55">
                        <p scope="col" class="des">Lokalizacja:</p>
                        <p scope="col" class="des2">{{ $event->location_shortcut }}</p>
                    </div>
            
            </div>
        
            <div class="expandable-content1">
    <div class="des-row2">
        <p scope="col" class="des5">Opis wydarzenia głównego:</p>
        <p scope="col" class="des22" id="short-description">
            @if (strlen($event->description) > 1200)
                {{ substr($event->description, 0, 1200) }}
                <a href="#" class="read-more-link">Czytaj dalej</a>
                <span class="more-content" style="display: none;">
                    {{ substr($event->description, 1200) }}
                    <a href="#" class="hide-content-link" style="display: none;">Schowaj</a>
                </span>
            @else
                {{ $event->description }}
            @endif
        </p>
    </div>
</div>


</div>
<div class="expandable-content" >
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col" class="name1">Wydarzenia</th>
      </tr>
    </thead>
  </table>

  <div class="container">
    <div class="grid">
      @foreach ($event->info as $info)
      @if (strtotime($info->date_start_rek) < strtotime('now') && strtotime($info->date_end) > strtotime('now'))
      <div class="event-wrapper" data-description="{{ $info->description }}">
        <div class="event"> 
          <div class="text">
            <p scope="col" class="des7">{{ $info->title }}</p>
            @if (strtotime($info->date_start) > strtotime('now'))
            <div class="des-row2">
              <p scope="col" class="des3">Rozpoczęcie:</p>
              <p scope="col" class="des4">{{ $info->date_start->format('d-m-Y') }} godz. {{$info->date_start->format('H:i') }}</p>
            </div>
            @endif

            <div class="des-row2">
              <p scope="col" class="des3">Zakończenie:</p>
              <p scope="col" class="des4">{{ $info->date_end->format('d-m-Y') }} godz. {{$info->date_end->format('H:i') }}</p>
            </div>
     
            @if (strtotime($info->date_start) > strtotime('now') && strtotime($info->date_start_rek) > strtotime('now'))
                <div class="des-row2">
                    <p scope="col" class="des3">Rozpoczęcie zapisów:</p>
                    <p scope="col" class="des4">{{ $info->date_start_rek->format('d-m-Y')}} godz. {{$info->date_start_rek->format('H:i') }}</p>
                </div>
            @endif

            @if (strtotime($info->date_start) > strtotime('now'))
            <div class="des-row2">
              <p scope="col" class="des3">Zakończenie zapisów:</p>
              <p scope="col" class="des4">{{ $info->date_end_rek->format('d-m-Y') }} godz. {{$info->date_end_rek->format('H:i') }}</p>
            </div>
            @endif
            <div class="des-row2">
              <p scope="col" class="des3">Prowadzący: {{ $info->speaker_first_name }}  {{ $info->speaker_last_name }}</p>
            </div>
            <div class="des-row2">
              <p scope="col" class="des3">Ilość miejsc: {{ $info->number_seats }}</p>
            </div>
       
            <div class="btn-container">
            @if (strtotime($info->date_start) > strtotime('now'))
    @if (strtotime($info->date_start_rek) < strtotime('now') && strtotime($info->date_end_rek) > strtotime('now'))
        @php
            $participantId = Auth::id();
            $eventDetailsId = $info->id;
            
            $registration = DB::table('event_participants')
                ->where('participants_id', $participantId)
                ->where('event_details_id', $eventDetailsId)
                ->whereNull('deleted_at')
                ->whereNull('event_participants.number_of_people')
                ->get();
        @endphp

        @if ($registration->isNotEmpty())
            <button class="btn sign" type="button" disabled>Jesteś już zapisany/a</button>
        @else
            <form method="POST" action="/signup">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <input type="hidden" name="event_details_id" value="{{ $info->id }}">
                <button type="submit" class="btn sign" >Zapisz się</button>
            </form>
        @endif
    @else
        <button class="btn sign" type="button" disabled>Zapisz się</button>
    @endif
    @endif
    <button class="btn show-sub-events" data-info-id="{{ $info->id }}">Pokaż szczegóły</button>

</div>



            </div>
            @if (strtotime($info->date_start) > strtotime('now'))
            @if(Auth::user() && Auth::user()->role == '2')
              @if (strtotime($info->date_start_rek) < strtotime('now') && strtotime($info->date_end_rek) > strtotime('now'))
                @if($info->type == 1)
                  <a href="{{ route('zapisz', $info->id) }}"  class="hidden btn">Zapis Grupowy</a>
                  @else
                  <a href="{{ route('zapisznr', $info->id) }}"  class="hidden btn">Zapis Grupowy</a>
                @endif
              @else
            
              <span class="btn disabled">Zapis Grupowy</span>
              @endif
            @endif
            @endif
          </div>
        </div>
      @endif
      @endforeach
    </div>
  </div>
</div>


                <div class="d-flex justify-content-end align-items-center">
                    <button class="btn btn-primary expand-button ">Pokaż wydarzenia</button>
                </div>
             
            </div>
        </div>
    
</div>

<div id="agreed22" class="dialog" style="display: none;">
<div class="dialog-background">
    <div class="dialog-content">
        <p id="dese">Opis wydarzenia:</p>
        <p id="eve_dese"></p>
        <button id="cancel-button">Wróć</button>
    </div>
</div>
</div>


<div id="agreed" class="dialog" style="display: none;">
    <div class="dialog-content2">
        <p>Czy na pewno chcesz się zapisać na wydarzenie?</p>
        <button id="confirm-agreed-button">Tak</button>
        <button id="cancel-agreed-button">Nie</button>
    </div>
    </div>

@endif


    <div class="footer">
    <p class="footer-text">@Sławek&Natan Company</p>
    </div>


    @endforeach
 
    <div class="container content-container">
    {{ $events->links() }}
    </div>
</div>



<script>


document.addEventListener('DOMContentLoaded', function () {
    const readMoreButtons = document.querySelectorAll('.read-more-link');
    const hideContentButtons = document.querySelectorAll('.hide-content-link');
    const moreContents = document.querySelectorAll('.more-content');

    readMoreButtons.forEach(function (readMoreButton, index) {
        readMoreButton.addEventListener('click', function (e) {
            e.preventDefault();
            moreContents[index].style.display = 'inline'; 
            readMoreButton.style.display = 'none'; 
            hideContentButtons[index].style.display = 'inline'; 
        });

        hideContentButtons[index].addEventListener('click', function (e) {
            e.preventDefault();
            moreContents[index].style.display = 'none'; 
            readMoreButton.style.display = 'inline'; 
            hideContentButtons[index].style.display = 'none'; 
        });
    });
});






document.addEventListener('DOMContentLoaded', function() {
    function obslugaZapisu(event) {
        event.preventDefault();
        var dialog = document.getElementById('agreed');
        dialog.style.display = 'flex'; 
        
      

        var przyciskPotwierdzenia = document.getElementById('confirm-agreed-button');
        var przyciskAnulowania = document.getElementById('cancel-agreed-button');
        
        przyciskPotwierdzenia.addEventListener('click', function() {

            var formularz = event.target.closest('form');
            if (formularz) {
                formularz.submit();
            }
            dialog.style.display = 'none'; 
        });
        
        przyciskAnulowania.addEventListener('click', function() {
       
            dialog.style.display = 'none'; 
        });
    }

    var przyciskiZapisu = document.querySelectorAll('.sign');
    przyciskiZapisu.forEach(function(przycisk) {
        przycisk.addEventListener('click', obslugaZapisu);
    });

 
});







  document.addEventListener('DOMContentLoaded', function() {
    function toggleDetails(event) {
      event.preventDefault();
      var button = event.target;
      var eventWrapper = button.closest('.table-wrapper');
      var eventId = eventWrapper.getAttribute('data-event-id');

    }
    


    
    var detailsButtons = document.querySelectorAll('.details-button');
    detailsButtons.forEach(function(button) {
      button.addEventListener('click', toggleDetails);
    });

    var expandButtons = document.querySelectorAll('.expand-button');
    var expandableContents = document.querySelectorAll('.expandable-content');

    expandButtons.forEach(function(button, index) {
      button.addEventListener('click', function() {
        expandableContents[index].classList.toggle('expanded');
        button.textContent = expandableContents[index].classList.contains('expanded') ? 'Schowaj wydarzenia' : 'Pokaż wydarzenia';

     
        if (!expandableContents[index].classList.contains('expanded')) {
          var subEvents = expandableContents[index].querySelectorAll('.sub-events');
          var showSubEventButtons = expandableContents[index].querySelectorAll('.show-sub-events');
          subEvents.forEach(function(subEvent, subEventIndex) {
            subEvent.style.display = 'none';
            showSubEventButtons[subEventIndex].textContent = 'Pokaż szczegóły';
          });
        }
      });
    });
  });

 




document.addEventListener('DOMContentLoaded', function() {

    function showDescription(description) {
        var dialog = document.getElementById('agreed22');
        var dialogContent = dialog.querySelector('.dialog-content');
        var descriptionElement = document.getElementById('eve_dese');
        descriptionElement.textContent = description;
        dialog.style.display = 'flex';

        var cancelButton = document.getElementById('cancel-button');

        cancelButton.addEventListener('click', function() {
            dialog.style.display = 'none';
            resetDialog();
        });
    }

 
    var showDetailsButtons = document.querySelectorAll('.show-sub-events');

    showDetailsButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var description = this.closest('.event-wrapper').getAttribute('data-description');
            showDescription(description);
            
        });
    });

    var dialog = document.getElementById('agreed22');
    var dialogBackground = dialog.querySelector('.dialog-background');

    dialogBackground.addEventListener('click', function(event) {
        if (event.target === dialogBackground) {
            dialog.style.display = 'none';
            resetDialog();
        }
    });


    function resetDialog() {
    var descriptionElement = document.getElementById('eve_dese');
    descriptionElement.textContent = ''; 


    var dialogContent = document.querySelector('.dialog-content2');
    dialogContent.scrollTop = 0;
}

});



  
  setTimeout(function() {
        var errorMessages = document.getElementsByClassName('error-message');
        for (var i = 0; i < errorMessages.length; i++) {
            errorMessages[i].style.display = 'none';
        }
    }, 2000); 
    document.addEventListener('DOMContentLoaded', function() {
        const statusMessage = document.getElementById('status-message');

        if (statusMessage) {
            setTimeout(function() {
                statusMessage.style.display = 'none';
            }, 5000); 
        }
    });



 
</script>

@endsection
