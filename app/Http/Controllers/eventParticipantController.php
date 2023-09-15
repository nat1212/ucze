<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\View\View;
use App\Models\EventDetails;
use App\Models\eventParticipant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Models\eventParticipantList;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class eventParticipantController extends Controller
{
    public function check($id){
        $participantId = Auth::id();
        
        $eventDetailsId = $id;

        $registration = DB::table('event_participants')
            ->where('participants_id', $participantId)
            ->where('event_details_id', $eventDetailsId)
            ->whereNull('deleted_at')
            ->whereNull('event_participants.number_of_people')
            ->get();

        if ($registration->isNotEmpty()) {
           return 0;
        } else {
            return 1;
        }
            }

        
            public function zapisz($id) : View
    {   
        $event = EventDetails::find($id);
        $Numberseats = EventDetails::find($id)->number_seats;
        $title = EventDetails::find($id)->title;
        return view('zapisz',[
            'event_details_id'=>$id,
           'event_details_title'=>$title,
           'seats'=>$Numberseats,
          ]);
    }
    public function list($id){
        $eventParticipants = EventParticipantList::select('first_name', 'last_name')
    ->join('event_participants', 'event_participant_lists.event_participants_id', '=', 'event_participants.id')
    ->where('event_participants.event_details_id',$id )

    ->get();

    $Numberseats = EventDetails::find($id)->number_seats;
    $title = EventDetails::find($id)->title;
    return view('list',[
        'event_details_title'=>$title,
        'event_details_id'=>$id,
        'names'=>$eventParticipants,
        'seats'=>$Numberseats,
       ]);
    }

    public function freeSeets($id,$registrationCount){
       
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


    public function freeSeets2($id){
       
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
    public function signup(Request $request)
    {
        $participantId = Auth::id();
        $dictionarySchool = Participant::find($participantId);

        $result = DB::table('participants')
            ->where('id', $participantId)
            ->whereNull('dictionary_schools_id')
            ->count();
    
        if ($result > 0) {
            $error = 'Uzupełnij dane.';
            return redirect()->route('event.list')->withErrors(['message' => $error]);
        }
    
        $eventDetailsId = $request->input('event_details_id');
        $isSaved = $this->check($eventDetailsId);
        $availableSeats = $this->freeSeets2($eventDetailsId);
       
    
        if ($isSaved == 1) {
            if ($availableSeats == 1) {
                $eventId = $request->input('event_id');
    
                try {
                    DB::transaction(function () use ($eventId, $eventDetailsId,$dictionarySchool) {
                        $eventUser = new eventParticipant();
                        $eventUser->date_report = now();
                        $eventUser->dictionary_schools_id = $dictionarySchool->id;
                        $eventUser->participants_id = Auth::id();
                        $eventUser->events_id = $eventId;
                        $eventUser->event_details_id = $eventDetailsId;
                        $eventUser->save();

                        $eventDetails = EventDetails::find($eventDetailsId);
                        $eventDetails->number_seats -= 1;
                        $eventDetails->save();
                    });
                    $statusMessage = 'Udało Ci się zapisać na wydarzenie!';
                    return redirect()->route('event.list')->with('status', $statusMessage);
                    
                } catch (\Exception $e) {
                    $error = 'Wystąpił problem podczas zapisywania. Spróbuj ponownie.';
                    return redirect()->route('event.list')->withErrors(['message' => $error]);
                }
            } else {
                $error = 'Nie ma już wolnych miejsc.';
                return redirect()->route('event.list')->withErrors(['message' => $error]);
            }
        } else {
            $error = 'Jesteś już zapisany/a.';
            return redirect()->route('event.list')->withErrors(['message' => $error]);
        }
    }


    public function store(Request $request){

        $participantId = Auth::id();
        $result = DB::table('participants')
            ->where('id', $participantId)
            ->whereNull('dictionary_schools_id')
            ->count();
    
        if ($result > 0) {
            $error = 'Uzupełnij dane.';
            return redirect()->route('event.list')->withErrors(['message' => $error]);
        }

        $participants = [];
        for ($i = 1; $i <= 10; $i++) {
            $first_name_key = "first_name{$i}";
            $last_name_key = "last_name{$i}";
    
            $first_name = $request->input($first_name_key);
            $last_name = $request->input($last_name_key);
    
            // Sprawdź, czy oba pola Imie i nazwisko są wypełnione
            if ($first_name && $last_name) {
                $participants[] = [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                ];
            }
        }
        if(count($participants)==0)
        {
            return redirect()->route('home');
        }
        $event_details_id = $request->input('event_details_id');
        $events_id = EventDetails::find($event_details_id)->events_id;
        
        $NumberParticipants=count($participants);
        $dictionarySchool = Participant::find($participantId);

        $result=$this->freeSeets($event_details_id,$NumberParticipants);
        if($result==1){
            $eventParticipant = new EventParticipant();
            $eventParticipant->date_report = now(); // Ustawiamy datę raportu na aktualną datę
            $eventParticipant->date_approval = null; // Ustawiamy datę zatwierdzenia na null
            $eventParticipant->number_of_people = count($participants);
            $eventParticipant->comments = null;
            $eventParticipant->dictionary_schools_id = $dictionarySchool->id;
            $eventParticipant->participants_id = $participantId;
            $eventParticipant->events_id = $events_id;
            $eventParticipant->event_details_id = $event_details_id;
        
            
            $eventParticipant->save();
            $eventDetails = EventDetails::find($event_details_id);
            $eventDetails->number_seats -= $NumberParticipants;
            $eventDetails->save();
            $eventParticipantId = $eventParticipant->id;
           
    
            foreach ($participants as $participantData){
                $eventParticipantList = new EventParticipantList();
                $eventParticipantList->event_participants_id=$eventParticipantId;
                $eventParticipantList->first_name= $participantData['first_name'];
                $eventParticipantList->last_name=$participantData['last_name'];
                $eventParticipantList->save();
                
            }
            $statusMessage = 'Udało Ci się zapisać grupę wydarzenie!';
            return redirect()->route('home')->with('status', $statusMessage);

        }
        else{
                 $error = 'Nie ma już wolnych miejsc.';
                return redirect()->route('home')->withErrors(['message' => $error]);
        }
      
    }



    public function leave($entryId)
{
    $entry = eventParticipant::find($entryId);

    if ($entry) {
        $entry->deleted_at = now();
        $entry->save();

        $eventDetails = EventDetails::find($entry->event_details_id);
        if ($eventDetails) {
            $eventDetails->number_seats += 1;
            $eventDetails->save();
        }
    }

    return new JsonResponse(['success' => true, 'message' => 'Udało się wypisać z wydarzenia!']);
}
}
