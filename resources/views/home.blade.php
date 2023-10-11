@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset('css/list2.css')}}">
<link rel="stylesheet" href="{{asset('css/table.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')

<div class="container">
<div class="side-bar">
        <div onclick="rat(1)" class="side-bar-info">
            Profil
        </div>
        <div  onclick="toggleExpand()" class="side-bar-underinfo" data-id="1">
            Edycja profilu
        </div>
        <div onclick="rat(2)"class="side-bar-info">
            Lista wydarzeń
        </div>
        <div onclick="rating(1)" class="side-bar-underinfo" data-id="2">
            Zapis indywidualny
        </div>
        <div onclick="rating(2)" class="side-bar-underinfo"data-id="2">
            Zapis grupowy
        </div>
        <div onclick="rat(3)" class="side-bar-info">
           Wygasłe wydarzenia
        </div>
        <div onclick="rating(3)" class="side-bar-underinfo"data-id="3">
            Zapis indywidualny
        </div>
        <div onclick="rating(4)" class="side-bar-underinfo" data-id="3">
            Zapis grupowy
        </div>
        <div  onclick="redirectToEventList(event)" class="side-bar-info">
            Wszyskie wydarzenia
        </div>
    </div>
        <div class="col-md-12"> 
            <div class="card card-left">
            <div class="card-header">
                <span>{{ __('Twój profil') }}</span>
                <span class="toggle-icon2" onclick="toggleExpand()">Edycja ⚙️</span>
            </div>
                
                <div class="card-body">

 <div class="table-info" data-id="1">
                
                <table id="example"  class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Nazwa wydarzenia</th>
                <th>Tytuł wydarzenia</th>
                <th>Prowadzący</th>
                <th>Data wydarzenia</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
           
            @foreach ($results as $result)
            @if ($result->date_end > now())
            <tr>
            <td>{{  $result->name}}</td>
            <td>{{  $result->title}}</td>
            <td>{{  $result->speaker_first_name}} {{  $result->speaker_last_name}}</td>
            <td> {{  $result->date_start->format('d-m-Y')}} godz. {{$result->date_start->format('H:i') }}<br>{{  $result->date_end->format('d-m-Y')}} godz. {{$result->date_end->format('H:i') }}</td>
            <td> 
            @if ($result->date_start > now())
            <a href="/leave/{{ $result->id }}" class="btn btn-primary leave-button leave-event-btn" data-date-start="{{ $result->date_start->format('Y-m-d H:i:s') }}" >Wypisz się</a>
            @else
                <a href="javascript:void(0)"  class="btn btn-primary disabled">Wypisz się</a>
            @endif
            <button class="btn btn-primary show-sub-event" data-result-id="{{ $result->id }}">Pokaż szczegóły</button>
            </td>
             </tr>

            @endif
            @endforeach
            
           
            </tbody>
        <tfoot>
        <tr>
        <th>Nazwa wydarzenia</th>
                <th>Tytuł wydarzenia</th>
                <th>Prowadzący</th>
                <th>Data wydarzenia</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>
<div class="table-info" data-id="2">
                
        <table id="example1"  class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Nazwa wydarzenia</th>
                <th>Liczba osób</th>
                <th>Typ listy</th>
                <th>Data wydarzenia</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
       
     
            @foreach ($groups as $group)
            @if ($group->date_end > now())
          
            <tr>
            <td>{{  $group->title}}</td>
            <td>{{  $group->number_of_people}}</td>
            <td>{{  $group->type}}</td>
            <td> {{  $group->date_start->format('d-m-Y')}} godz. {{$group->date_start->format('H:i') }}<br>{{  $group->date_end->format('d-m-Y')}} godz. {{$group->date_end->format('H:i') }}</td>
            <td>@if ($group->date_start > now())
                                    <a href="{{ route('list',$group->participant_id,) }}" class="btn btn-danger">Lista</a>
                                    @else
                                    <a href="{{ route('list', $group->id) }}" class="btn btn-danger disabled">Lista</a>
                                    @endif
                                    <button class="btn btn-primary show-sub-event" data-result-id="{{ $group->id }}">Pokaż szczegóły</button> </td>
             </tr>
          
            
            @endif
            @endforeach
            
            
           
            </tbody>
        <tfoot>
        <tr>
        <th>Nazwa wydarzenia</th>
                <th>Liczba osób</th>
                <th>Typ listy</th>
                <th>Data wydarzenia</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>
<div class="table-info" data-id="3">
                
                <table id="example"  class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Nazwa wydarzenia</th>
                <th>Tytuł wydarzenia</th>
                <th>Prowadzący</th>
                <th>Data wydarzenia</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
           
            @foreach ($results as $result)
            @if ($result->date_end <= now())
            <tr>
            <td>{{  $result->name}}</td>
            <td>{{  $result->title}}</td>
            <td>{{  $result->speaker_first_name}} {{  $result->speaker_last_name}}</td>
            <td> {{  $result->date_start->format('d-m-Y')}} godz. {{$result->date_start->format('H:i') }}<br>{{  $result->date_end->format('d-m-Y')}} godz. {{$result->date_end->format('H:i') }}</td>
            <td> </td>
          
             </tr>

            @endif
            @endforeach
            
           
            </tbody>
        <tfoot>
        <tr>
        <th>Nazwa wydarzenia</th>
                <th>Tytuł wydarzenia</th>
                <th>Prowadzący</th>
                <th>Data wydarzenia</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>
<div class="table-info" data-id="4">
                
        <table id="example1"  class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Nazwa wydarzenia</th>
                <th>Liczba osób</th>
                <th>Typ listy</th>
                <th>Data wydarzenia</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
       
     
            @foreach ($groups as $group)
            @if ($group->date_end <= now())
          
            <tr>
            <td>{{  $group->title}}</td>
            <td>{{  $group->number_of_people}}</td>
            <td>{{  $group->type}}</td>
            <td> {{  $group->date_start->format('d-m-Y')}} godz. {{$group->date_start->format('H:i') }}<br>{{  $group->date_end->format('d-m-Y')}} godz. {{$group->date_end->format('H:i') }}</td>
            <td>
                        </td>
             </tr>
          
            
            @endif
            @endforeach
            
            
           
            </tbody>
        <tfoot>
        <tr>
        <th>Nazwa wydarzenia</th>
                <th>Liczba osób</th>
                <th>Typ listy</th>
                <th>Data wydarzenia</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>



















                    @if (session('status'))
                        <div id="status-message" class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div id="update-message" class="alert alert-success" style="display: none;"></div>
                    @if ($errors->has('status'))
    <div id="update-message2" class="alert alert-danger">
        {{ $errors->first('status') }}
    </div>
@endif
                    <div id="update-message2" class="alert alert-danger" style="display: none;"></div>
                    @if(isset($error) && !empty($error))
                        <div class="link-frame">
                            <p>{{ $error }} -> <a href="/szkola">Kliknij tutaj</a></p>
                        </div>
                    @endif
     
                    <div id="update-message-container"></div>

                  
                    <h4 class="expand-toggle3" onclick="redirectToEventList(event)">Lista wszystkich aktualnych wydarzeń:  <span class="toggle-icon">►</span></h4>



<h4 class="expand-toggle">Lista wydarzeń na które jesteś zapisany/a: <span class="toggle-icon">▼</span></h4>
<div class="grid-wrapper">
    <div class="grid">
        @if(isset($results))
            @foreach ($results as $result)
                @if ($result->date_end > now())
                    <div class="event-wrapper" data-end-date="{{ $result->date_end }}"  data-description="{{ $result->description }}">
                        <div class="event"> 
                            <div class="text">
                                <p class="des7">{{ $result->title }}</p>
                                <div class="des-row">
                                    <p class="des3">Rozpoczęcie wydarzenia:</p>
                                    <p class="des4">{{ $result->date_start->format('d-m-Y') }} godz. {{$result->date_start->format('H:i') }}</p> 
                                </div>
                                <div class="des-row">
                                    <p class="des3">Zakończenie wydarzenia:</p>
                                    <p class="des4">{{ $result->date_end->format ('d-m-Y')}} godz. {{$result->date_end->format('H:i') }}</p> 
                                </div>
                                
                                <div class="btn-container">
                                    @if ($result->date_start > now())
                                    <a href="/leave/{{ $result->id }}" class="btn btn-primary leave-button leave-event-btn" data-date-start="{{ $result->date_start->format('Y-m-d H:i:s') }}" >Wypisz się</a>
                                    @else
                                        <a href="javascript:void(0)"  class="btn btn-primary disabled">Wypisz się</a>
                                    @endif
                                    <button class="btn btn-primary show-sub-event" data-result-id="{{ $result->id }}">Pokaż szczegóły</button>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>

@if(Auth::user() && Auth::user()->role == '2')
<h4 class="expand-toggle">Lista wydarzeń na które jest zapisana grupa: <span class="toggle-icon">▼</span></h4>
<div class="grid-wrapper">
    <div class="grid">
        @if(isset($groups))
            @foreach ($groups as $group)
            @if($group->type == 1)
                @if ($group->date_end > now())
                    <div class="event-wrapper" data-end-date="{{ $group->date_end }}"  data-description="{{ $group->description }}">
                        <div class="event"> 
                            <div class="text">
                                <p class="des7">{{ $group->title }}</p>
                                <div class="des-row">
                                    <p class="des3">Rozpoczęcie wydarzenia:</p>
                                    <p class="des4">{{ $group->date_start->format('d-m-Y') }} godz. {{$group->date_start->format('H:i') }}</p> 
                                </div>
                                <div class="des-row">
                                    <p class="des3">Zakończenie wydarzenia:</p>
                                    <p class="des4">{{ $group->date_end->format('d-m-Y') }} godz. {{$group->date_end->format('H:i') }}</p> 
                                </div>
                                <div class="btn-container">
                                    @if ($group->date_start > now())
                                    <a href="{{ route('list',$group->participant_id,) }}" data-date-start="{{ $group->date_start->format('Y-m-d H:i:s') }}" class="btn btn-danger leave">Lista</a>
                                    @else
                                    <a href="{{ route('list', $group->id) }}" class="btn btn-danger disabled">Lista</a>
                                    @endif
                                    <button class="btn btn-primary show-sub-event" data-result-id="{{ $group->id }}">Pokaż szczegóły</button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
             @endif
            @endforeach
        @endif
        @if(isset($numeric))
            @foreach ($numeric as $liste)
            @if($liste->type == 2)
                @if ($liste->date_end > now())
                    <div class="event-wrapper" data-end-date="{{ $liste->date_end }}"  data-description="{{ $liste->description }}">
                        <div class="event"> 
                            <div class="text">
                                <p class="des7">{{ $liste->title }}</p>
                                <div class="des-row">
                                    <p class="des3">Rozpoczęcie wydarzenia:</p>
                                    <p class="des4">{{ $liste->date_start->format('d-m-Y') }} godz. {{$liste->date_start->format('H:i') }}</p> 
                                </div>
                                <div class="des-row">
                                    <p class="des3">Zakończenie wydarzenia:</p>
                                    <p class="des4">{{ $liste->date_end->format('d-m-Y') }} godz. {{$liste->date_end->format('H:i') }}</p> 
                                </div>
                                <div class="btn-container">
                                    @if ($liste->date_start > now())
                                    <a href="{{ route('listnr',$liste->participant_id,) }}"data-date-start="{{ $liste->date_start->format('Y-m-d H:i:s') }}" class="btn btn-danger leave">Lista</a>
                                    @else
                                    <a href="{{ route('listnr', $liste->id) }}" class="btn btn-danger disabled">Lista</a>
                                    @endif
                                    <button class="btn btn-primary show-sub-event" data-result-id="{{ $liste->id }}">Pokaż szczegóły</button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
             @endif
            @endforeach
        @endif
    </div>
</div>
@endif


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
                                    <p class="des3">Rozpoczęcie wydarzenia:</p>
                                    <p class="des4">{{ $result->date_start->format('d-m-Y') }} godz. {{$result->date_start->format('H:i') }}</p> 
                                </div>
                                <div class="des-row">
                                    <p class="des3">Zakończenie wydarzenia:</p>
                                    <p class="des4">{{ $result->date_end->format('d-m-Y') }} godz. {{$result->date_end->format('H:i') }}</p> 
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>

@if(Auth::user() && Auth::user()->role == '2')
<h4 class="expand">Lista wygasłych grupowych wydarzeń: <span class="toggle-icon">▼</span></h4>
<div class="grid-wrapper3">
    <div class="grid">
        @if(isset($groups))
            @foreach ($groups as $group)
            @if($group->type == 1)
                @if ($group->date_end <= now()) 
                    <div class="event-wrapper">
                        <div class="event"> 
                            <div class="text">
                                <p class="des7">{{ $group->title }}</p>
                                <div class="des-row">
                                    <p class="des3">Rozpoczęcie wydarzenia:</p>
                                    <p class="des4">{{ $group->date_start->format('d-m-Y') }} godz. {{$group->date_start->format('H:i') }}</p> 
                                </div>
                                <div class="des-row">
                                    <p class="des3">Zakończenie wydarzenia:</p>
                                    <p class="des4">{{ $group->date_end->format('d-m-Y') }} godz. {{$group->date_end->format('H:i') }}</p> 
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @endif
            @endforeach
        @endif

        @if(isset($numeric))
            @foreach ($numeric as $liste)
            @if($liste->type == 2)
                @if ($liste->date_end <= now()) 
                    <div class="event-wrapper">
                        <div class="event"> 
                            <div class="text">
                                <p class="des7">{{ $liste->title }}</p>
                                <div class="des-row">
                                    <p class="des3">Rozpoczęcie wydarzenia:</p>
                                    <p class="des4">{{ $liste->date_start->format('d-m-Y') }} godz. {{$liste->date_start->format('H:i') }}</p> 
                                </div>
                                <div class="des-row">
                                    <p class="des3">Zakończenie wydarzenia:</p>
                                    <p class="des4">{{ $liste->date_end->format('d-m-Y') }} godz. {{$liste->date_end->format('H:i') }}</p> 
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @endif
            @endforeach
        @endif
    </div>
</div>
@endif

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
                                                <input id="first_name" type="text" class="form-control tracked-field" name="first_name" value="{{ $participant->first_name }}" placeholder="Imię" required autocomplete="Imię" autofocus>
                                            </div>
                                        </div>

                                        <div class="spacer"></div>

                                        <div class="row">
                                            <label for="last_name" class="col-md-4 col-form-label text-md-end">{{ __('Nazwisko') }}</label>
                                            <div class="col-md-3">
                                                <input id="last_name" type="text" class="form-control tracked-field" name="last_name" value="{{ $participant->last_name  }}" placeholder="Nazwisko" required autocomplete="Nazwisko" autofocus>
                                            </div>
                                        </div>

                                        <div class="spacer"></div>

                                        <div class="row">
                                            <label for="sex" class="col-md-4 col-form-label text-md-end " >{{ __('Płeć') }}</label>
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
                                            <label for="birth_date" class="col-md-4 col-form-label text-md-end ">{{ __('Data urodzin') }}</label>
                                            <div class="col-md-3">
                                                <input id="birth_date" type="date" class="form-control" name="birth_date" value="{{ $participant->birth_date }}">
                                            </div>
                                        </div>

                                        <div class="spacer"></div>

                                        <div class="row1">
                                        <div class="col-md-5">
                                            <div class="d-flex  justify-content-start align-items-center">
                                            <button id="updateProfileBtn" type="button" class="btn btn-primary btn-sm" onclick="confirmUpdate()" disabled>Zapisz zmiany</button>

                                                <button type="button" class="btn btn-secondary btn-sm" onclick="cancelChanges()">Anuluj</button>
                                            </div>
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

<div class="footer">
    <p class="footer-text">@Sławek&Natan Company</p>
</div>
<div id="custom-dialog" class="dialog">
    <div class="dialog-content">
        <p>Czy na pewno chcesz zapisać zmiany?</p>
        <button id="confirm-button">Tak</button>
        <button id="cancel-button">Nie</button>
    </div>
</div>

<div id="leave-dialog" class="dialog">
    <div class="dialog-content">
        <p>Czy na pewno chesz wypisać się z wydarzenia</p>
        <button id="confirm-leave-button">Tak</button>
        <button id="cancel-leave-button">Nie</button>
    </div>
</div>

<div id="agreed2" class="dialog2" style="display: none;">
    <div class="dialog-content2">
        <p id="dese">Opis wydarzenia:</p>
        <p id="eve_dese"></p>
        <button id="cancel2-button">Wróć</button>
    </div>
</div>


</div>

<script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script defer src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script defer src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script defer >$(document).ready(function () {
    var table = $('#example').DataTable();
    
});
$(document).ready(function () {
    var table = $('#example1').DataTable();
    
});
</script>
<script>
function rat(x) {
 
    const dataId = `[data-id="${x}"]`;
    const side_bar = document.querySelectorAll(`.side-bar-underinfo${dataId}`);

    side_bar.forEach(div => {
    if (div.classList.contains("selected")) {
        div.classList.remove("selected");
    } else {
        div.classList.add("selected");
    }
    });
  
}

</script>
<script>
function rating(x) {
    number = x;
    console.log(number);
    const dataId = `[data-id="${x}"]`;
    const buttons = document.querySelectorAll(".table-info");
    buttons.forEach(div => div.classList.remove("selected"));
  
   // const selectedButton = document.querySelector(`.side-bar-info${dataId}`);
    const underinfoElements = document.querySelectorAll(`.table-info${dataId}`);
    
   // selectedButton.classList.add("selected");
    underinfoElements.forEach(div => div.classList.add("selected"));
}

</script>
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


function toggleExpand() {
    const gridWrapper2 = document.querySelector('.grid-wrapper2');
    if (gridWrapper2.style.display === 'block') {
        gridWrapper2.style.display = 'none';
    } else {
        gridWrapper2.style.display = 'block';
    }
}

 function redirectToEventList(event) {
        event.stopPropagation(); 
        window.location.href = "{{ route('event.list') }}";
    }

    document.addEventListener('DOMContentLoaded', function() {
    var csrfToken = '{{ csrf_token() }}';

    var updateProfileBtn = document.getElementById('updateProfileBtn');
    var formInputs = document.querySelectorAll('.tracked-field');

    var sexField = document.getElementById('sex');
    var birthDateField = document.getElementById('birth_date');

    var originalValues = {};

    formInputs.forEach(function(input) {
        originalValues[input.id] = input.value;

        input.addEventListener('input', function() {
            var anyFieldFilled = Array.from(formInputs).some(function(input) {
                return input.value.trim() !== '';
            });

            var anyValueChanged = Array.from(formInputs).some(function(input) {
                return input.value !== originalValues[input.id];
            });

            updateProfileBtn.disabled = !anyFieldFilled || !anyValueChanged;
        });
    });

    sexField.addEventListener('change', function() {
        updateProfileBtn.disabled = false;
    });

    birthDateField.addEventListener('input', function() {
        updateProfileBtn.disabled = false;
    });
});



document.getElementById('updateProfileBtn').addEventListener('click', function() {
    var dialog = document.getElementById('custom-dialog');
    dialog.style.display = 'flex';
});

document.getElementById('confirm-button').addEventListener('click', function() {
    var form = document.getElementById('updateProfileForm');
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    var updateMessage = document.getElementById('update-message');
                    updateMessage.textContent = response.message;
                    updateMessage.style.display = 'block'; 
                    setTimeout(function() {
                        updateMessage.style.display = 'none'; 
                        location.reload();
                    }, 1500); 
                } else {
                    var updateMessage = document.getElementById('update-message2');
                    updateMessage.textContent = response.message;
                    updateMessage.style.display = 'block'; 
                    setTimeout(function() {
                        updateMessage.style.display = 'none'; 
                        location.reload();
                    }, 3000);
                }
            } 
        }
    };

    xhr.open('POST', form.action);
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
    xhr.send(formData);

    var dialog = document.getElementById('custom-dialog');
    dialog.style.display = 'none';
});

document.getElementById('cancel-button').addEventListener('click', function() {
    var dialog = document.getElementById('custom-dialog');
    dialog.style.display = 'none';
});



document.addEventListener('DOMContentLoaded', function() {
    var showDetailsButtons = document.querySelectorAll('.show-sub-event');
    var dialog = document.getElementById('agreed2');
    var cancelButton = document.getElementById('cancel2-button');

    showDetailsButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var description = this.closest('.event-wrapper').getAttribute('data-description');
            var descriptionElement = document.getElementById('eve_dese');
            descriptionElement.textContent = description;

            dialog.style.display = 'flex';
        });
    });

  
    dialog.addEventListener('click', function(event) {
        if (event.target === dialog) {
            dialog.style.display = 'none';
            resetDialog();
        }
    });

    cancelButton.addEventListener('click', function() {
        dialog.style.display = 'none';
        resetDialog();
    });
    function resetDialog() {
    var descriptionElement = document.getElementById('eve_dese');
    descriptionElement.textContent = ''; 


    var dialogContent = document.querySelector('.dialog-content2');
    dialogContent.scrollTop = 0;
}
});



var leaveButtons = document.querySelectorAll('.leave-event-btn');


leaveButtons.forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.preventDefault();

        var dialog = document.getElementById('leave-dialog');
        dialog.style.display = 'flex';

        var id = this.getAttribute('href').split('/').pop();
        dialog.setAttribute('data-entry-id', id);
    });
});

    document.getElementById('confirm-leave-button').addEventListener('click', function() {
        var dialog = document.getElementById('leave-dialog');
        dialog.style.display = 'none';

        var id = dialog.getAttribute('data-entry-id');


        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/leave/' + id, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                    var updateMessage = document.getElementById('update-message');
                    updateMessage.textContent = response.message;
                    updateMessage.style.display = 'block'; 
                    setTimeout(function() {
                        updateMessage.style.display = 'none'; 
                        location.reload();
                    }, 1500); 
                } 
            } 
        }
    };
        xhr.send();
        var dialog = document.getElementById('custom-dialog');
    dialog.style.display = 'none';
    });

    document.getElementById('cancel-leave-button').addEventListener('click', function() {
        var dialog = document.getElementById('leave-dialog');
        dialog.style.display = 'none';
    });


    function cancelChanges() {
    var firstNameInput = document.getElementById("first_name");
    firstNameInput.value = "{{ $participant->first_name }}";
    
    var lastNameInput = document.getElementById("last_name");
    lastNameInput.value = "{{ $participant->last_name }}";
    
    var sexInput = document.getElementById("sex");
    sexInput.value = "{{ $participant->sex }}";
    
    var birthDateInput = document.getElementById("birth_date");
    birthDateInput.value = "{{ $participant->birth_date }}";
    
  
    var updateProfileBtn = document.getElementById('updateProfileBtn');
    updateProfileBtn.disabled = true;
}


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

                    const btnContainer = event.querySelector('.btn-container');
                    if (btnContainer) {
                        btnContainer.remove();
                    }

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

setInterval(sprawdzDatyWydarzen, 1000);
document.addEventListener('DOMContentLoaded', sprawdzDatyWydarzen);


function disableLeaveButtonsBasedOnTime() {
  const leaveButtons = document.querySelectorAll('.leave');

  leaveButtons.forEach(button => {
    const startDate = new Date(button.dataset.dateStart);
    const currentTime = new Date();

    const timeDifference = startDate - currentTime;

    if (timeDifference <= 0) {
      button.classList.add('disabled');
      button.removeEventListener('click', confirmWypisz);
    } else {
      button.classList.remove('disabled');
      button.addEventListener('click', confirmWypisz);

      setTimeout(() => {
        button.classList.add('disabled');
        button.removeEventListener('click', confirmWypisz);
      }, timeDifference);
    }
  });
}

// Call the function on DOMContentLoaded and set an interval to continuously check
document.addEventListener('DOMContentLoaded', disableLeaveButtonsBasedOnTime);
setInterval(disableLeaveButtonsBasedOnTime, 1000);


    $(document).ready(function() {
 
        var statusDuration = {{ session('status_duration', 3000) }};


        setTimeout(function() {
            $("#status-message").fadeOut();
        }, statusDuration);
    });

    setTimeout(function() {
            var updateMessage2 = document.getElementById('update-message2');
            if (updateMessage2) {
                updateMessage2.style.display = 'none';
            }
        }, 2000); 
 

</script>

@endsection
