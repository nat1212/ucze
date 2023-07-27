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
                  
                    <h4 class="expand-toggle" onclick="redirectToEventList()">Lista wszystkich wydarzeń:  <span class="toggle-icon">►</span></h4>

                    <h4 class="expand-toggle">Lista wydarzeń na które jesteś zapisany/a:  <span class="toggle-icon">▼</span></h4>
                    <div class="grid-wrapper">
                    <div class="grid">
                        @if(isset($results))
                            @foreach ($results as $result)
                                <div class="event-wrapper">
                                    <div class="event"> 
                                        <div class="text">
                                            <p class="des7">{{ $result->title }}</p>
                                            <div class="des-row">
                                                <p class="des3">Data rozpoczęcia wydarzenia:</p>
                                                <p class="des4">{{ $result->date_start }}</p> 
                                            </div>
                                            <div class="des-row">
                                                <p class="des3">Data zakończenia wydarzenia:</p>
                                                <p class="des4">{{ $result->date_end }}</p> 
                                            </div>
                                            <div class="btn-container">
                                                <a href="/leave/{{ $result->id }}" class="btn btn-primary">Wypisz się</a>
                                                <a href="{{ route('event.list')}}" class="btn btn-primary">Pokaż szczegóły</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
            <form method="POST" action="{{ route('participant.updateFirstName', $participant->id) }}" onsubmit="return confirm('Czy na pewno chcesz zapisać zmiany?')">
    @csrf
    <div class="row">
        <label for="first_name" class="col-md-4 col-form-label text-md-end">{{ __('Imię') }}</label>
        <div class="col-md-3">
            <input id="first_name" type="text" class="form-control" name="first_name" value="{{ $participant->first_name }}" placeholder="Imię" required autocomplete="Imię" autofocus>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Zapisz</button>
        </div>
    </div>
</form>

                    <div class="spacer"></div>

                    <form method="POST" action="{{ route('participant.updateLastName', $participant->id) }}" onsubmit="return confirm('Czy na pewno chcesz zapisać zmiany?')">
    @csrf
    <div class="row">
        <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Nazwisko') }}</label>
        <div class="col-md-3">
            <input id="last_name" type="text" class="form-control" name="last_name" value="{{ $participant->last_name  }}" placeholder="Nazwisko" required autocomplete="Nazwisko" autofocus>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Zapisz</button>
        </div>
    </div>
</form>

                    <div class="spacer"></div>


                    <form method="POST" action="{{ route('participant.updateSex', $participant->id) }}" onsubmit="return confirm('Czy na pewno chcesz zapisać zmiany?')">
                    @csrf
                    <div class="row">
                        <label for="sex" class="col-md-4 col-form-label text-md-end">{{ __('Płeć') }}</label>
                        <div class="col-md-3">
                            <select id="sex" class="form-control" name="sex" required autofocus>
                                <option value="m" @if($participant->sex === 'm') selected @endif>Mężczyzna</option>
                                <option value="k" @if($participant->sex === 'k') selected @endif>Kobieta</option>
                                <option value="n" @if($participant->sex === 'n') selected @endif>Nie chcę podawać</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Zapisz</button>
                        </div>
                    </div>
                    </form>

                    <div class="spacer"></div>



                    <form method="POST" action="{{ route('participant.updateBirthDate', $participant->id) }}" onsubmit="return confirm('Czy na pewno chcesz zapisać zmiany?')">
    @csrf
                    <div class="row">
                        <label for="birth_date" class="col-md-4 col-form-label text-md-end">{{ __('Data urodzin') }}</label>
                        <div class="col-md-3">
                            <input id="birth_date" type="date" class="form-control" name="birth_date" value="{{ $participant->birth_date }}">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Zapisz</button>
                        </div>
                    </div>
                    </form>
                    <div class="spacer"></div>

                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-3">
                     
                        <a href="change-password" class="btn btn-primary">Zmień hasło</a>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

    </div>
</div>
</div>
                    </div>
    




    <script>


const expandToggles = document.querySelectorAll('.expand-toggle');
expandToggles.forEach(toggle => {
    toggle.addEventListener('click', () => {
        const gridWrapper = toggle.parentElement.querySelector('.grid-wrapper');
        if (gridWrapper.style.display === 'block') {
            gridWrapper.style.display = 'none';
            toggle.classList.remove('expanded');
        } else {
            gridWrapper.style.display = 'block';
            toggle.classList.add('expanded');
        }
    });
});
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
    function redirectToEventList() {
  window.location.href = "{{ route('event.list') }}";
}
    
</script>

@endsection
