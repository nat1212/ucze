<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\EventDetails;
use App\Models\eventParticipant;
use App\Models\Participant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\eventParticipantList;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class EventGroupController extends Controller
{
    public function addGroup(Request $request): View
    {
        $specificEventId = null;

        if ($request->has('specific_event_id')) {
            $specificEventId = $request->input('specific_event_id');
        }



       
        $currentDateTime = Carbon::now();
        $events = Event::where('date_start_publi', '<', $currentDateTime)
        ->where('date_end_publi', '>', $currentDateTime)
        ->whereNull('deleted_at')
        ->where('statuses_id', 1)
        ->with(['info' => function ($query) use ($currentDateTime) {
            $query->whereNull('deleted_at')
                ->where('date_start_rek', '<', $currentDateTime)
                ->where('date_end', '>', $currentDateTime)
                ->orderBy('date_start', 'asc');
        }])
        ->orderBy('date_start', 'asc')
        ->paginate(2);
    
    
    foreach ($events as $event) {
        $event->date_start = Carbon::parse($event->date_start);
        $event->date_end = Carbon::parse($event->date_end);
        $event->date_start_rek = Carbon::parse($event->date_start_rek);
        $event->date_end_rek = Carbon::parse($event->date_end_rek);

        foreach($event->info as $info)
        {
            $info->date_start = Carbon::parse($info->date_start);
            $info->date_end = Carbon::parse($info->date_end);
            $info->date_start_rek = Carbon::parse($info->date_start_rek);
            $info->date_end_rek = Carbon::parse($info->date_end_rek);
            
        }

    }
    
    
    return view('add_group', [
        'events' => $events,
        'specificEventId' => $specificEventId,
    ]);
    
    }
    public function show($id)
    {
        // Pobierz szczegóły wydarzenia na podstawie identyfikatora
        $event = Event::findOrFail($id);

        // Przekaż szczegóły wydarzenia do widoku event.list
        return view('add_group', compact('add_group'));
    }
  
    
public function add_group_submit(Request $request)
{

    $participantId = Auth::id();
    $result = DB::table('participants')
        ->where('id', $participantId)
        ->whereNull('dictionary_schools_id')
        ->count();

    if ($result > 0) {
        $error = 'Uzupełnij dane.';
        return redirect()->route('event.list')->withErrors(['message' => $error]);
    }
    
    $firstNames = $request->input('first_name');
    $lastNames = $request->input('last_name');

    // Przechodź przez każdą parę imię/nazwisko i zapisz do bazy danych
    foreach ($firstNames as $index => $firstName) {
        $person = new eventParticipantList();
        $person->first_name = $firstName;
        $person->last_name = $lastNames[$index];
        $person->event_participants_id = 1;
        $person->save();
    }
    $statusMessage = 'Dodano grupę do wydarzenia!';
    return redirect()->route('home')->with('status', $statusMessage);
}


}
