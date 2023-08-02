<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Event;
use App\Models\EventDetails;
use App\Models\eventParticipant;
use App\Models\Participant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $specificEventId = null;

        if ($request->has('specific_event_id')) {
            $specificEventId = $request->input('specific_event_id');
        }



       
        $currentDateTime = Carbon::now();
        $events = Event::where('date_start_publi', '<', $currentDateTime)
                   ->where('date_end_publi', '>', $currentDateTime)
                   ->whereNull('deleted_at')
                   ->where('statuses_id',1)
                   ->with(['info' => function ($query) {
                    $query->whereNull('deleted_at');
                }])
                ->with(['info' => function ($query) {
                   
                    $query->orderBy('date_start', 'asc');
                }])->orderBy('date_start', 'asc')->paginate(2);
                  
                foreach ($events as $event) {
                    $event->date_start = Carbon::parse($event->date_start);
                    $event->date_end = Carbon::parse($event->date_end);
                    $event->date_start_rek = Carbon::parse($event->date_start_rek);
                    $event->date_end_rek = Carbon::parse($event->date_end_rek);
                    
                }
                       

            $event->info = EventDetails::where('date_start_rek', '<', $currentDateTime)
                   ->where('date_end_rek', '>', $currentDateTime)
                   ->paginate(2);

                   foreach ($event->info as $info) {
                    $info->date_start = Carbon::parse($info->date_start);
                    $info->date_end = Carbon::parse($info->date_end);
                    $info->date_start_rek = Carbon::parse($info->date_start_rek);
                    $info->date_end_rek = Carbon::parse($info->date_end_rek);
                }
       
        return view('event.list', [
            'events' => $events,
            'buttons'=>$event->info,
            'specificEventId' => $specificEventId,
           
        ]);
    }
    public function show($id)
    {
        // Pobierz szczegóły wydarzenia na podstawie identyfikatora
        $event = Event::findOrFail($id);

        // Przekaż szczegóły wydarzenia do widoku event.list
        return view('event.list', compact('event'));
    }
  
    public function search(Request $request)
    {
        $searchTerm = $request->input('search_name');
    
        $currentDateTime = Carbon::now();

        $events = Event::where('date_start_publi', '<', $currentDateTime)
                       ->where('date_end_publi', '>', $currentDateTime)
                       ->whereNull('deleted_at')
                       ->where('statuses_id', 1)
                       ->where('name', 'LIKE', "%{$searchTerm}%")
                       ->with(['info' => function ($query) {
                           $query->whereNull('deleted_at');
                           $query->orderBy('date_start', 'asc');
                       }])
                       ->orderBy('date_start', 'asc')
                       ->paginate(2);
    
        foreach ($events as $event) {
            $event->date_start = Carbon::parse($event->date_start);
            $event->date_end = Carbon::parse($event->date_end);
            $event->date_start_rek = Carbon::parse($event->date_start_rek);
            $event->date_end_rek = Carbon::parse($event->date_end_rek);

        
        foreach ($event->info as $info) {
            $info->date_start = Carbon::parse($info->date_start);
            $info->date_end = Carbon::parse($info->date_end);
            $info->date_start_rek = Carbon::parse($info->date_start_rek);
            $info->date_end_rek = Carbon::parse($info->date_end_rek);
        }
    }
    
        return view('event.list', [
            'events' => $events,
            'searchTerm' => $searchTerm,
            
        ]);
    }
    
}
/*events = Event::paginate(2);
        $loggedInParticipantId = auth()->user()->id;

        // Przygotowanie tablicy z informacją o aktywności przycisku dla każdego wydarzenia
        $buttonActivity = [];

        foreach ($events as $event) {
            $participant = $event->participants()
                ->where('participants.id', $loggedInParticipantId)
                ->wherePivotNull('deleted_at')
                ->first();

            $isEnrolled = $participant !== null;

            $buttonActivity[$event->id] = !$isEnrolled;
        }

        return view('event.list', [
            'events' => $events,
            'buttonActivity' => $buttonActivity,
        ]);
    }*/