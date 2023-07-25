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
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <div class="link-frame">
                    <span>Zaktualizuj swoją szkołę -> </span>
                    <a href="#">Pokaż szczegóły</a>
                    </div>

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
            <form method="POST" action="">
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

                    <form method="POST" action="">
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


                    <form method="POST" action="">
                     @csrf
                    <div class="row">
                        <label for="sex" class="col-md-4 col-form-label text-md-end">{{ __('Płeć') }}</label>
                        <div class="col-md-3">
                            <input id="sex" type="text" class="form-control" name="sex" value="{{ $participant->sex  }}" placeholder="Płeć" required autocomplete="Płeć" autofocus>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Zapisz</button>
                        </div>
                    </div>
                    </form>
                    <div class="spacer"></div>



                    <form method="POST" action="">
                     @csrf
                    <div class="row">
                        <label for="birth_date" class="col-md-4 col-form-label text-md-end">{{ __('Data urodzin') }}</label>
                        <div class="col-md-3">
                            <input id="birth_date" type="datetime-local" class="form-control" name="birth_date" value="{{ $participant->birth_date }}">
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

    
</script>

@endsection
