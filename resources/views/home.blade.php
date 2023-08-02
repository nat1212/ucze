@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset('css/list2.css')}}">
@endsection

@section('content')

<div class="container">
        <div class="col-md-12"> 
            <div class="card card-left">
            <div class="card-header">
                <span>{{ __('Twój profil') }}</span>
                <span class="toggle-icon2" onclick="toggleExpand()">⚙️</span>
            </div>
                
                <div class="card-body">
                    @if (session('status'))
                        <div id="status-message" class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                 
                    @if(isset($error) && !empty($error))
                        <div class="link-frame">
                            <p>{{ $error }} -> <a href="/szkola">Kliknij tutaj</a></p>
                        </div>
                    @endif
                  
                    <h4 class="expand-toggle3" onclick="redirectToEventList(event)">Lista wszystkich wydarzeń:  <span class="toggle-icon">►</span></h4>



<h4 class="expand-toggle">Lista wydarzeń na które jesteś zapisany/a: <span class="toggle-icon">▼</span></h4>
<div class="grid-wrapper">
    <div class="grid">
        @if(isset($results))
            @foreach ($results as $result)
                @if ($result->date_end > now())
                    <div class="event-wrapper" data-end-date="{{ $result->date_end }}">
                        <div class="event"> 
                            <div class="text">
                                <p class="des7">{{ $result->title }}</p>
                                <div class="des-row">
                                    <p class="des3">Data rozpoczęcia wydarzenia:</p>
                                    <p class="des4">{{ $result->date_start->format('Y-m-d') }} godz. {{$result->date_start->format('H:i') }}</p> 
                                </div>
                                <div class="des-row">
                                    <p class="des3">Data zakończenia wydarzenia:</p>
                                    <p class="des4">{{ $result->date_end->format('Y-m-d') }} godz. {{$result->date_end->format('H:i') }}</p> 
                                </div>
                                <div class="btn-container">
                                    @if ($result->date_start > now())
                                        <a href="/leave/{{ $result->id }}" class="btn btn-primary leave-button" data-date-start="{{ $result->date_start->format('Y-m-d H:i:s') }}" onclick="return confirmWypisz()">Wypisz się</a>
                                    @else
                                        <a href="javascript:void(0)" class="btn btn-primary disabled">Wypisz się</a>
                                    @endif
                                    <a href="{{ route('event.list')}}" class="btn btn-primary">Pokaż szczegóły</a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>


<h4 class="expand">Lista wygasłych wydarzeń: <span class="toggle-icon">▼</span></h4>
<div class="grid-wrapper3">
    <div class="grid">
        @if(isset($results))
            @foreach ($results as $result)
                @if ($result->date_end <= now()) 
                    <div class="event-wrapper">
                        <div class="event"> 
                            <div class="text">
                                <p class="des7">{{ $result->title }}</p>
                                <div class="des-row">
                                    <p class="des3">Data rozpoczęcia wydarzenia:</p>
                                    <p class="des4">{{ $result->date_start->format('Y-m-d') }} godz. {{$result->date_start->format('H:i') }}</p> 
                                </div>
                                <div class="des-row">
                                    <p class="des3">Data zakończenia wydarzenia:</p>
                                    <p class="des4">{{ $result->date_end->format('Y-m-d') }} godz. {{$result->date_end->format('H:i') }}</p> 
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>

                <div class="grid-wrapper2">
                    <div class="container2">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">{{ __('Edycja Profilu') }}</div>

                                <div class="card-body">
                                <form id="updateProfileForm" method="POST" action="{{ route('participant.updateProfile', $participant->id) }}">

                                        @csrf
                                        <div class="row">
                                            <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('Imię') }}</label>
                                            <div class="col-md-3">
                                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ $participant->first_name }}" placeholder="Imię" required autocomplete="Imię" autofocus>
                                            </div>
                                        </div>

                                        <div class="spacer"></div>

                                        <div class="row">
                                            <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Nazwisko') }}</label>
                                            <div class="col-md-3">
                                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ $participant->last_name  }}" placeholder="Nazwisko" required autocomplete="Nazwisko" autofocus>
                                            </div>
                                        </div>

                                        <div class="spacer"></div>

                                        <div class="row">
                                            <label for="sex" class="col-md-4 col-form-label text-md-end">{{ __('Płeć') }}</label>
                                            <div class="col-md-3">
                                                <select id="sex" class="form-control" name="sex" required autofocus>
                                                    <option value="m" @if($participant->sex === 'm') selected @endif>Mężczyzna</option>
                                                    <option value="k" @if($participant->sex === 'k') selected @endif>Kobieta</option>
                                                    <option value="n" @if($participant->sex === 'n') selected @endif>Nie chcę podawać</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="spacer"></div>

                                        <div class="row">
                                            <label for="birth_date" class="col-md-4 col-form-label text-md-end">{{ __('Data urodzin') }}</label>
                                            <div class="col-md-3">
                                                <input id="birth_date" type="date" class="form-control" name="birth_date" value="{{ $participant->birth_date }}">
                                            </div>
                                        </div>

                                        <div class="spacer"></div>

                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-md-3">
                                            <button id="updateProfileBtn" type="button" class="btn btn-primary" onclick="confirmUpdate()">Zapisz zmiany</button>

                                            </div>
                                        </div>

                                        </form>
                    
                                        <div class="spacer"></div>

                                        <div class="row align-items-center justify-content-start">
                                            <div class="col-md-3">
                                                <a href="change-password" class="btn btn-primary">Zmień hasło</a>
                                            </div>
                                        </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div> 
</div>
</div>



    <script>


 const expandToggles = document.querySelectorAll('.expand, .expand-toggle');
    expandToggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const gridWrapper = toggle.nextElementSibling; 
            if (gridWrapper.style.display === 'block') {
                gridWrapper.style.display = 'none';
                toggle.classList.remove('expanded');
            } else {
                gridWrapper.style.display = 'block';
                toggle.classList.add('expanded');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
    let lastUpdateTime = 0;
    const updateInterval = 1000;
    const expiredEventsGrid = document.querySelector('.grid-wrapper3 .grid');

    function moveExpiredEvents(timestamp) {
        if (timestamp - lastUpdateTime >= updateInterval) {
            lastUpdateTime = timestamp;

            const now = new Date();

            const activeEvents = document.querySelectorAll('.grid-wrapper .event-wrapper');
            activeEvents.forEach(event => {
                const endDate = new Date(event.dataset.endDate);

                if (endDate <= now) {
                    // Usunięcie przycisków "Wypisz się" i "Pokaż szczegóły" z wydarzenia
                    const btnContainer = event.querySelector('.btn-container');
                    if (btnContainer) {
                        btnContainer.remove();
                    }

                    // Przeniesienie wydarzenia do drugiej listy
                    expiredEventsGrid.appendChild(event);
                }
            });
        }

        requestAnimationFrame(moveExpiredEvents);
    }

    moveExpiredEvents(0);
});

    
function sprawdzDatyWydarzen() {
  const przyciskiWypiszSie = document.querySelectorAll('.leave-button');

  przyciskiWypiszSie.forEach(przycisk => {
    const dataRozpoczecia = new Date(przycisk.dataset.dateStart);
    const roznicaCzasu = dataRozpoczecia - new Date();

    if (roznicaCzasu <= 0) {
      przycisk.classList.add('disabled');
      przycisk.removeEventListener('click', confirmWypisz); 
    } else {
      przycisk.classList.remove('disabled');
      przycisk.addEventListener('click', confirmWypisz); 


      setTimeout(() => {
        przycisk.classList.add('disabled');
        przycisk.removeEventListener('click', confirmWypisz); 
      }, roznicaCzasu);
    }
  });

}

  document.addEventListener('DOMContentLoaded', sprawdzDatyWydarzen);



function toggleExpand() {
    const gridWrapper2 = document.querySelector('.grid-wrapper2');
    if (gridWrapper2.style.display === 'block') {
        gridWrapper2.style.display = 'none';
    } else {
        gridWrapper2.style.display = 'block';
    }
}



document.addEventListener('DOMContentLoaded', function() {
        const statusMessage = document.getElementById('status-message');

        if (statusMessage) {
            setTimeout(function() {
                statusMessage.style.display = 'none';
            }, 5000); 
        }
    });
    function redirectToEventList(event) {
        event.stopPropagation(); 
        window.location.href = "{{ route('event.list') }}";
    }
    
document.getElementById('updateProfileBtn').addEventListener('click', function() {
        var form = document.getElementById('updateProfileForm');
        var formData = new FormData(form);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert(response.message);
                    } else {
                        alert('Wystąpił błąd podczas aktualizacji profilu.');
                    }
                } else {
                    alert('Wystąpił błąd podczas wysyłania żądania.');
                }
            }
        };

        xhr.open('POST', form.action);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.send(formData);
    });

   
    function confirmUpdate() {
        var confirmed = confirm('Czy na pewno chcesz zapisać zmiany?');

        if (confirmed) {

            var form = document.getElementById('updateProfileForm');
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
            };

            xhr.open('POST', form.action);
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.send(formData);
        }
    }
    function confirmWypisz() {
  if (confirm('Czy na pewno chcesz się wypisać?')) {
    return true;
  } else {
    return false;
  }
}
</script>

@endsection
