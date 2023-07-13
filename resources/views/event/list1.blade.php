@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h1>WYDARZENIA</h1>
            </div>
            <div class="col-6">
                <a class="float-right" href="{{ route('event.list') }}">
                    <button type="button" class="btn btn-primary">Dodaj</button>
                </a>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">name</th>
                        <th scope="col">shortcut</th>
                        <th scope="col">city</th>
                        <th scope="col">street</th>
                        <th scope="col">date_start</th>
                        <th scope="col">date_end</th>
                        <th scope="col">date_start_rek</th>
                        <th scope="col">date_end_rek</th>
                        <th scope="col">date_start_publi</th>
                        <th scope="col">date_end_publi</th>
                        <th scope="col">status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>
                                @if ($event->details->isNotEmpty())
                                    <button class="btn btn-link show-details" data-id="{{ $event->id }}">></button>
                                @else
                                    <button class="btn btn-link" disabled>></button>
                                @endif
                            </td>
                            <td>{{ $event->name }}</td>
                            <td>{{ $event->shortcut }}</td>
                            <td>{{ $event->city }}</td>
                            <td>{{ $event->street }}</td>
                            <td>{{ $event->date_start }}</td>
                            <td>{{ $event->date_end }}</td>
                            <td>{{ $event->date_start_rek }}</td>
                            <td>{{ $event->date_end_rek }}</td>
                            <td>{{ $event->date_start_publi }}</td>
                            <td>{{ $event->date_end_publi }}</td>
                            <td>{{ $event->status->name }}</td>
                            <td>
                            </td>
                        </tr>
                        @if ($event->details->isNotEmpty())
                            <tr class="details">
                                <td colspan="12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Imię prezentera</th>
                                                <th>Nazwisko prezentera</th>
                                                <th>Tytuł</th>
                                                <th>Data rozpoczęcia</th>
                                                <th>Data zakończenia</th>
                                                <th>Opis</th>
                                                <th>Komentarze</th>
                                                <th>Liczba miejsc</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($event->details as $detail)
                                                <tr>
                                                    <td>{{ $detail->speaker_first_name }}</td>
                                                    <td>{{ $detail->speaker_last_name }}</td>
                                                    <td>{{ $detail->title }}</td>
                                                    <td>{{ $detail->date_start }}</td>
                                                    <td>{{ $detail->date_end }}</td>
                                                    <td>{{ $detail->description }}</td>
                                                    <td>{{ $detail->comments }}</td>
                                                    <td>{{ $detail->number_seats }}</td>
                                                    <td>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            {{ $events->links() }}
        </div>
    </div>
@endsection


@section('javascript')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        jQuery(function($) {
            $('select').val('');
            $('.details').hide(); // Schowaj wszystkie podwydarzenia (details) na początku

            $('.show-details').click(function() {
                var detailsRow = $(this).closest('tr').next('.details');
                detailsRow.toggle(); // Pokaż/ukryj podwydarzenie po kliknięciu "Show details"
            });

            $('.show-details').each(function() {
                var eventRow = $(this).closest('tr');
                if (!eventRow.next('.details').length) {
                    $(this).prop('disabled', true);
                    $(this).removeClass('show-details'); // Usuń klasę show-details, jeśli brak podwydarzenia
                }
            });
        });
    </script>
@endsection

