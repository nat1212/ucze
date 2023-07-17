<?php

namespace App\Http\Controllers;

use App\Models\eventParticipant;
use Illuminate\Support\Facades\Auth;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Models\eventParticipantList;

class eventParticipantController extends Controller
{
    public function signup(Request $request){
       
        
        
     $eventId = $request->input('event_id');
     $eventDetailsId = $request->input('event_details_id');
     
     $eventUser = new eventParticipant();
     $eventUser->date_report = now();
     $eventUser->dictionary_schools_id=1;
     $eventUser->participants_id = Auth::id(); 
     $eventUser->events_id = $eventId;
     $eventUser->event_details_id = $eventDetailsId;
     
      
     $eventUser->save();
     
    /* $eventParticipantList = new eventParticipantList();
        $participant = Participant::find(Auth::id());
     $eventParticipantList->first_name = $participant->first_name; 
     $eventParticipantList->last_name = $participant->last_name;
     $eventParticipantList->event_participants_id = $eventUser->id;
     $eventParticipantList->save();*/
    // return view("/home");
    return redirect()->route('home');
    }
    public function leave($entryId){
        // Znajdź odpowiedni rekord w bazie danych, który użytkownik chce opuścić
        $entry = eventParticipant::find($entryId);

        if ($entry) {
    // Ustaw bieżącą datę i godzinę jako wartość dla kolumny 'delated_at'
        $entry->delated_at = now(); // lub Carbon::now() dla zaawansowanych operacji z datą

    // Zapisz zmiany w bazie danych
        $entry->save();
    }
    return redirect()->route('home');
    }
    
}
