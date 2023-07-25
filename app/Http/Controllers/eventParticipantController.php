<?php

namespace App\Http\Controllers;

use App\Models\EventDetails;
use App\Models\eventParticipant;
use Illuminate\Support\Facades\Auth;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Models\eventParticipantList;
use Illuminate\Support\Facades\DB;

class eventParticipantController extends Controller
{
    public function check($id){
        $participantId = Auth::id();
        
        $eventDetailsId = $id;

        $registration = DB::table('event_participants')
            ->where('participants_id', $participantId)
            ->where('event_details_id', $eventDetailsId)
            ->whereNull('deleted_at')
            ->get();

        if ($registration->isNotEmpty()) {
           return 0;
        } else {
            return 1;
        }
            }
    
    public function freeSeets($id){
       
        $eventDetailsId = $id;

        $eventDetails = EventDetails::find($id);

        $registrationCount = DB::table('event_participants')
        ->where('event_details_id', $eventDetailsId)
        ->whereNull('deleted_at')
        ->count();

        $availableSeats = $eventDetails->number_seats - $registrationCount;

        if($availableSeats <= 0)
        {
            return 0;

        }
        else{
            return 1;
        }
    }

    public function signup(Request $request){

        $participantId = Auth::id();
        $result=DB::table('participants')
        ->where('id',$participantId)
        ->whereNull('dictionary_schools_id')
        ->count();
        if($result>0)
        {
            $error = 'Uzupełnij dane.';
            return redirect()->route('event.list')->withErrors(['message' => $error]);
        }

        $eventDetailsId = $request->input('event_details_id');
        $isSaved = $this->check($eventDetailsId);
        $availableSeats =$this->freeSeets($eventDetailsId);
     if($isSaved==1)  {
        if($availableSeats==1)
        {
            $eventId = $request->input('event_id');
    
     
            $eventUser = new eventParticipant();
            $eventUser->date_report = now();
            $eventUser->dictionary_schools_id=1;
            $eventUser->participants_id = Auth::id(); 
            $eventUser->events_id = $eventId;
            $eventUser->event_details_id = $eventDetailsId;
            
             
            $eventUser->save();
            return redirect()->route('home');
        }
        else{
            $error = 'Nie ma wolnych miejsc.';
        return redirect()->route('event.list')->withErrors(['message' => $error]);
        }
     
    
    }else{
        $error = 'Jestes juz zapisany.';
        return redirect()->route('event.list')->withErrors(['message' => $error]);
    }
    /* $eventParticipantList = new eventParticipantList();
        $participant = Participant::find(Auth::id());
     $eventParticipantList->first_name = $participant->first_name; 
     $eventParticipantList->last_name = $participant->last_name;
     $eventParticipantList->event_participants_id = $eventUser->id;
     $eventParticipantList->save();*/
    // return view("/home");
   


   
    }


    public function leave($entryId){
        // Znajdź odpowiedni rekord w bazie danych, który użytkownik chce opuścić
        $entry = eventParticipant::find($entryId);

        if ($entry) {
    // Ustaw bieżącą datę i godzinę jako wartość dla kolumny 'delated_at'
        $entry->deleted_at = now(); // lub Carbon::now() dla zaawansowanych operacji z datą

    // Zapisz zmiany w bazie danych
        $entry->save();
    }
    return redirect()->route('home');
    }

  
    
}
