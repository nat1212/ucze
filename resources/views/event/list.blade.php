@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset('css/list.css')}}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8 text-center">
            <h1>WYDARZENIA NA UCZELNI:</h1>
        </div>
    </div>
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
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
    
    <div class="row">
        <div class="table-wrapper ">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="name1">{{ $event->name }}</th>
                    </tr>
                </thead>
            </table>
            <div>
            <div class="des-row">
            <div class="left-content">
            
            <div class="des-row">
                    <p scope="col" class="des " >Data rozpoczęcia wydarzenia:</p>
                    <p scope="col" class="des2 ">{{ $event->date_start }}</p>
            </div>
            <div class="des-row">
                    <p scope="col" class="des" >Data zakończenia wydarzenia:</p>
                    <p scope="col" class="des2" >{{ $event->date_end }}</p>
            </div>
            <div class="des-row">
                    <p scope="col" class="des" >Rozpoczęcie rekrutacji:</p>
                    <p scope="col" class="des2" >{{ $event->date_start_rek }}</p>
            </div>
            <div class="des-row">
                    <p scope="col" class="des" >Zakończenie rekrutacji:</p>
                    <p scope="col" class="des2">{{ $event->date_end_rek }}</p>
            </div>      
            <div class="des-row">
   
                    <p scope="col" class="des" >Status wydarzenia:</p>
                    <p scope="col" class="des2" >{{ $event->status->name }}</p>
            </div>
            <div class="des-row">
   
              <p scope="col" class="des" >Status wydarzenia:</p>
              <p scope="col" class="des2" >{{ $event->status->name }}</p>
              
            </div>
            
            </div>
        
                <div class="right-content expandable-content1"style="display:none;">
                           
                    <div class="des-row">
                        <p scope="col" class="des5">Ulica:</p>
                        <p scope="col" class="des6">{{ $event->city }} ul.{{ $event->street }}  {{ $event->zip_code }}</p>
                    </div>
                
                    <div class="des-row">
                        <p scope="col" class="des5">Nr budynku:</p>
                        <p scope="col" class="des6">{{ $event->no_building }}</p>
                    </div>
                    <div class="des-row">
                        <p scope="col" class="des5">Klasa:</p>
                        <p scope="col" class="des6">{{ $event->no_room }}</p>
                    </div>
                    <div class="des-row">
                        <p scope="col" class="des5">Skrót:</p>
                        <p scope="col" class="des6">{{ $event->location_shortcut }}</p>
                    </div>
                    <div class="des-row2">
                        <p scope="col" class="des5">Opis wydarzenia głównego:</p>
                        <p scope="col" class="des22">{{ $event->description }}</p>
                    </div>
                    </div>
             
                </div>
<div class="expandable-content">
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
     
      <div class="event-wrapper">
        <div class="event"> 
          <div class="text">
            <p scope="col" class="des7">{{ $info->title }}</p>
            <div class="des-row2">
              <p scope="col" class="des3">Data rozpoczęcia wydarzenia:</p>
              <p scope="col" class="des4">{{ $info->date_start }}</p>
            </div>
            <div class="des-row2">
              <p scope="col" class="des3">Data zakończenia wydarzenia:</p>
              <p scope="col" class="des4">{{ $info->date_end }}</p>
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
                                    <button type="submit" class="btn btn-primary">Zapisz się</button>
                                </form>
                                @else
                                    <button  class="btn btn-primary" type="button" disabled>Zapisz się</button>
                                @endif
              <button class="btn show-sub-events" data-info-id="{{ $info->id }}">Pokaż szczegóły</button>
            </div>
          </div>
  
          <div class="sub-events" style="display:none;">
            <div class="des-row2">
              <p scope="col" class="des3">Imię prowadzącego:</p>
              <p scope="col" class="des4">{{ $info->speaker_first_name }}</p>
            </div>
            <div class="des-row2">
              <p scope="col" class="des3">Nazwisko prowadzącego:</p>
              <p scope="col" class="des4">{{ $info->speaker_last_name }}</p>
            </div>
            <div class="des-row2">
              <p scope="col" class="des3">Opis:</p>
              <p scope="col" class="des4">{{ $info->description }}</p>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>


                <div class="d-flex justify-content-end align-items-center">
                    <button class="btn btn-primary expand-button ">Pokaż wydarzenia</button>
                    <button class="btn btn-primary details-button" data-event-id="{{ $event->id }}">Pokaż szczegóły</button>
                </div>
             
            </div>
        </div>
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

        // Dodajemy poniższy kod, aby automatycznie chować szczegóły podwydarzeń, gdy schowamy wydarzenia
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
    function toggleDetails(event) {
      event.preventDefault();
      var button = event.target;
      var eventWrapper = button.closest('.event');
      var expandableContent = eventWrapper.querySelector('.sub-events');
      
      if (expandableContent) {
        expandableContent.style.display = expandableContent.style.display === 'none' ? 'block' : 'none';
        button.textContent = expandableContent.style.display === 'none' ? 'Pokaż szczegóły' : 'Ukryj szczegóły';
      }
    }

    var detailsButtons = document.querySelectorAll('.show-sub-events');
    detailsButtons.forEach(function(button) {
      button.addEventListener('click', toggleDetails);
    });
  });

 
</script>



@endsection
