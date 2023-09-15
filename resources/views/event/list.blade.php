@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset('css/list.css')}}">
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-8 text-center">
        <h1>AKTUALNE WYDARZENIA NA UCZELNI:</h1>
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
        <form action="{{ route('events.search') }}" method="GET" class="d-flex align-items-center">
            <input type="text" class="form-control" name="search_name" placeholder="Szukaj po nazwie" value="" autocomplete="off">
            <button type="submit" class="btn btn-primary">Szukaj</button>
        </form>
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
            
            <div class="des-row">
    <p scope="col" class="des">Data rozpoczęcia:</p>
    <p scope="col" class="des2">{{ $event->date_start->format('Y-m-d') }} </p>
    <p scope="col" class="des2">godz.{{ $event->date_start->format('H:i') }}</p>
</div>
<div class="des-row">
    <p scope="col" class="des">Data zakończenia:</p>
    <p scope="col" class="des2">{{ $event->date_end->format('Y-m-d') }}</p>
    <p scope="col" class="des2">godz.{{ $event->date_end->format('H:i') }}</p>
</div>

            <div class="des-row">
   
                    <p scope="col" class="des" >Status wydarzenia:</p>
                    <p scope="col" class="des2" >{{ $event->status->name }}</p>
            </div>
            <div class="des-row">
                        <p scope="col" class="des">Skrót:</p>
                        <p scope="col" class="des2">{{ $event->location_shortcut }}</p>
                    </div>
            
            </div>
        
                <div class="right-content expandable-content1"style="display:none;">
            
                    <div class="des-row">
                        <p scope="col" class="des5">Sala:</p>
                        <p scope="col" class="des6">{{ $event->no_room }}</p>
                    </div>
            
                    <div class="des-row2">
                        <p scope="col" class="des5">Opis wydarzenia głównego:</p>
                        <p scope="col" class="des22">{{ $event->description }}</p>
                    </div>
                    </div>
             
                </div>
<div class="expandable-content" >
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col" class="name1">Wydarzenia:</th>
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
            <div class="des-row2">
              <p scope="col" class="des3">Data rozpoczęcia:</p>
              <p scope="col" class="des4">{{ $info->date_start->format('Y-m-d') }} godz. {{$info->date_start->format('H:i') }}</p>
            </div>
            <div class="des-row2">
              <p scope="col" class="des3">Data zakończenia:</p>
              <p scope="col" class="des4">{{ $info->date_end->format('Y-m-d') }} godz. {{$info->date_end->format('H:i') }}</p>
            </div>
            <div class="des-row2">
              <p scope="col" class="des3">Data rozpoczęcia zapisów:</p>
              <p scope="col" class="des4">{{ $info->date_start_rek->format('Y-m-d') }} godz. {{$info->date_start_rek->format('H:i') }}</p>
            </div>
            <div class="des-row2">
              <p scope="col" class="des3">Data zakończenia zapisów:</p>
              <p scope="col" class="des4">{{ $info->date_end_rek->format('Y-m-d') }} godz. {{$info->date_end_rek->format('H:i') }}</p>
            </div>
            <div class="des-row2">
              <p scope="col" class="des3">Prowadzący: {{ $info->speaker_first_name }}  {{ $info->speaker_last_name }}</p>
            </div>
            <div class="des-row2">
              <p scope="col" class="des3">Ilość miejsc: {{ $info->number_seats }}</p>
            </div>
       
            <div class="btn-container">
            @if (strtotime($info->date_start_rek) < strtotime('now') && strtotime($info->date_end_rek) > strtotime('now'))
                                <form method="POST" action="/signup">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <input type="hidden" name="event_details_id" value="{{ $info->id }}">
                                    <button type="submit" class="btn sign">Zapisz się</button>
                                </form>
                                @else
                                    <button  class="btn sign" type="button" disabled>Zapisz się</button>
            @endif
              <button class="btn show-sub-events" data-info-id="{{ $info->id }}">Pokaż szczegóły</button>
   
            </div>
            </div>
            @if(Auth::user() && Auth::user()->role == '2')
            <a href="{{ route('zapisz', $info->id) }}"class=" hidden btn">Zapis Grupowy</a>
            @endif
          </div>
        </div>
      @endif

      <div id="agreed" class="dialog" style="display: none;">
    <div class="dialog-content2">
        <p>Czy na pewno chcesz się zapisać na wydarzenie?</p>
        <button id="confirm-agreed-button">Tak</button>
        <button id="cancel-agreed-button">Nie</button>
    </div>
    </div>




    
      @endforeach
    </div>
  </div>
</div>


                <div class="d-flex justify-content-end align-items-center">
                    <button class="btn btn-primary expand-button ">Pokaż wydarzenia</button>
                    <button class="btn btn-primary details-button" data-event-id="{{ $event->id }}" >Pokaż szczegóły</button>
                </div>
             
            </div>
        </div>
    
</div>

<div id="agreed22" class="dialog" style="display: none;">
    <div class="dialog-content">
        <p id="dese">Opis wydarzenia:</p>
        <p id="eve_dese"></p>
        <button id="cancel-button">Wróć</button>
    </div>
</div>



@endif


    <div class="footer">
    <p class="footer-text">@Sławek&Natan Company</p>
    </div>


    @endforeach
 

    {{ $events->links() }}
</div>



<script>


  document.addEventListener('DOMContentLoaded', function() {
    function toggleDetails(event) {
      event.preventDefault();
      var button = event.target;
      var eventWrapper = button.closest('.table-wrapper');
      var eventId = eventWrapper.getAttribute('data-event-id');

      if (button.classList.contains('details-button')) {
        var expandableContent1 = eventWrapper.querySelector('.expandable-content1');
        if (expandableContent1) {
          expandableContent1.style.display = expandableContent1.style.display === 'none' ? 'block' : 'none';
          button.textContent = expandableContent1.style.display === 'none' ? 'Pokaż szczegóły' : 'Ukryj szczegóły';

          var desElements = eventWrapper.querySelectorAll('.des');
          var des2Elements = eventWrapper.querySelectorAll('.des2');
          var isDetailsVisible = expandableContent1.style.display !== 'none';

          desElements.forEach(function(element) {
            element.classList.toggle('des-small', isDetailsVisible);
          });

          des2Elements.forEach(function(element) {
            element.classList.toggle('des-small', isDetailsVisible);
          });
        }
      } 
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
      
        var showDetailsButtons = document.querySelectorAll('.show-sub-events');

        showDetailsButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var dialog = document.getElementById('agreed22');
                dialog.style.display = 'flex'; 
                var description = this.closest('.event-wrapper').getAttribute('data-description');
            var descriptionElement = document.getElementById('eve_dese');
            descriptionElement.textContent = description;
                var cancelButton = document.getElementById('cancel-button');

                cancelButton.addEventListener('click', function() {
             
                    dialog.style.display = 'none'; 
                });
            });
        });
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
