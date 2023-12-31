<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\View\View;
use App\Models\EventDetails;
use App\Models\eventParticipant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Models\Participant;
use Illuminate\Support\Carbon;
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
        $type = EventDetails::find($id)->type;
        return view('zapisz',[
            'event_details_id'=>$id,
           'event_details_title'=>$title,
           'seats'=>$Numberseats,
           'type'=>$type,
          ]);
    }

    public function zapisznr($id) : View
    {   
        $event = EventDetails::find($id);
        $Numberseats = EventDetails::find($id)->number_seats;
        $title = EventDetails::find($id)->title;
        $type = EventDetails::find($id)->type;
        return view('zapisznr',[
            'event_details_id'=>$id,
           'event_details_title'=>$title,
           'seats'=>$Numberseats,
           'type'=>$type,
          ]);
    }
    public function list($list){
        $eventParticipants = EventParticipantList::select('id','first_name', 'last_name')
    ->where('event_participants_id', $list)
    ->whereNull('deleted_at')
    ->get();
       
    $id = DB::table('event_participants')
    ->select('event_details_id')
    ->where('id', $list)
    ->first();
    

    $eventDetailsId = $id->event_details_id;
    $Numberseats = EventDetails::find($eventDetailsId)->number_seats;
    $date = EventDetails::find($eventDetailsId)->date_start;
    $title = EventDetails::find($eventDetailsId)->title;
    return view('list',[
        'event_details_id'=>$eventDetailsId,
        'names'=>$eventParticipants,
        'seats'=>$Numberseats,
        'date'=>$date,
        'event_id'=>$list,
        'event_details_title'=>$title,
       ]);
    }
    public function listnr($list){

    $id = DB::table('event_participants')
    ->select('event_details_id','number_of_people')
    ->where('id', $list)
    ->first();
    

    $eventDetailsId = $id->event_details_id;
    $Numberseats = EventDetails::find($eventDetailsId)->number_seats;
    $date = EventDetails::find($eventDetailsId)->date_start;
    $title = EventDetails::find($eventDetailsId)->title;
    $numberOfPeople = $id->number_of_people;

    return view('listnr',[
        'event_details_id'=>$eventDetailsId,
        'seats'=>$Numberseats,
        'event_id'=>$list,
        'date'=>$date,
        'event_details_title'=>$title,
        'number_of_people' => $numberOfPeople,
       ]);
    }

    public function freeSeets($id, $NumberParticipants){
        $eventDetailsId = $id;
    
        $eventDetails = EventDetails::find($id);
    
        $availableSeats = $eventDetails->number_seats - $NumberParticipants;
    
        if ($availableSeats < 0) {
            return 0;
        } else {
            return 1;
        }
    }
    
    public function freeSeets3($id, $NumberParticipants,$idd){
        $eventDetailsId = $id;
    
        $eventParti = eventParticipant::find($idd);
    
        $availableSeats = $eventParti->number_of_people - $NumberParticipants;
    
        if ($availableSeats < 0) {
            return 0;
        } else {
            return 1;
        }
    }

    public function freeSeets2($id){
       
        $eventDetailsId = $id;

        $eventDetails = EventDetails::find($id);

        $registrationCount = DB::table('event_participants')
        ->where('event_details_id', $eventDetailsId)
        ->whereNull('event_participants.number_of_people')
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
   

        $result = DB::table('participants')
            ->where('id', $participantId)
            ->whereNull('dictionary_schools_id')
            ->count();
    
        if ($result > 0) {
            $error = 'Aby odblokować profil uzupełnij dane szkoły!';
            return redirect()->route('event.list')->withErrors(['message' => $error]);
        }
    
        $eventDetailsId = $request->input('event_details_id');
        $isSaved = $this->check($eventDetailsId);

        
        $availableSeats = $this->freeSeets2($eventDetailsId);
       

        if ($isSaved == 1) {
            if ($availableSeats == 1) {
                $eventId = $request->input('event_id');
    
                try {
                    DB::transaction(function () use ($eventId, $eventDetailsId,$participantId) {
                        $eventUser = new eventParticipant();
                        $eventUser->date_report = now();
                        $eventUser->dictionary_schools_id = Participant::find($participantId)->dictionary_schools_id;
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
    dd($e->getMessage());
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
            $error = 'Aby odblokować profil uzupełnij dane szkoły!';
            return redirect()->route('event.list')->withErrors(['message' => $error]);
        }

        $participants = [];
        for ($i = 1; $i <= 100; $i++) {
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
            $eventParticipant->dictionary_schools_id = Participant::find($participantId)->dictionary_schools_id;
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
            return redirect()->route('home')->with('status', $statusMessage)->with('executeJs', true);

        }
        else{
                 $error = 'Nie ma już wolnych miejsc.';
                return redirect()->route('home')->withErrors(['message' => $error])->with('executeJs', true);
        }
      
    }


    public function storenr(Request $request){

        $participantId = Auth::id();
        $result = DB::table('participants')
            ->where('id', $participantId)
            ->whereNull('dictionary_schools_id')
            ->count();
    
        if ($result > 0) {
            $error = 'Aby odblokować profil uzupełnij dane szkoły!';
            return redirect()->route('event.list')->withErrors(['message' => $error]);
        }

        $request->validate([
            'number_of_people' => 'required|integer|min:1',
        ], [
            'number_of_people.required' => 'Proszę wprowadzić liczbę.',
        ]);
   

        $event_details_id = $request->input('event_details_id');
        $events_id = EventDetails::find($event_details_id)->events_id;
        
        $NumberParticipants = $request->input('number_of_people');
        $dictionarySchool = Participant::find($participantId);

        $result=$this->freeSeets($event_details_id,$NumberParticipants);
        if($result==1){
            $eventParticipant = new EventParticipant();
            $eventParticipant->date_report = now(); // Ustawiamy datę raportu na aktualną datę
            $eventParticipant->date_approval = null; // Ustawiamy datę zatwierdzenia na null
            $eventParticipant->number_of_people = $NumberParticipants;
            $eventParticipant->comments = null;
            $eventParticipant->dictionary_schools_id = Participant::find($participantId)->dictionary_schools_id;
            $eventParticipant->participants_id = $participantId;
            $eventParticipant->events_id = $events_id;
            $eventParticipant->event_details_id = $event_details_id;
        
            
            $eventParticipant->save();
            $eventDetails = EventDetails::find($event_details_id);
            $eventDetails->number_seats -= $NumberParticipants;
            $eventDetails->save();
            
            $statusMessage = 'Udało Ci się zapisać grupę na wydarzenie!';
            return redirect()->route('home')->with('status', $statusMessage)->with('executeJs', true);

        }
        else{
                 $error = 'Nie ma już wolnych miejsc.';
                return redirect()->route('event.list')->withErrors(['message' => $error])->with('executeJs', true);
        }
      
    }
    public function edit(Request $request)
    {
       
         $event_participant_id = $request->input('id');
       
        $events = eventParticipant::find($event_participant_id);

        $eventParticipants = EventParticipantList::where('event_participants_id', $event_participant_id)
    ->whereNull('deleted_at')
    ->get(); 


$firstNames = [];
$lastNames = [];
$i = 0;

while ($request->has("first{$i}")) {
    $firstNames[] = $request->input("first{$i}");
    $lastNames[] = $request->input("last{$i}");
    $i++;
}

foreach ($eventParticipants as $key => $eventParticipant) {
    $eventParticipant->update([
        'first_name' => $firstNames[$key],
        'last_name' => $lastNames[$key],
    ]);
}

        $participants = [];
        for ($i = 1; $i <= 100; $i++) {
            $first_name_key = "first_name{$i}";
            $last_name_key = "last_name{$i}";
    
            $first_name = $request->input($first_name_key);
            $last_name = $request->input($last_name_key);
    
        
            if ($first_name && $last_name) {
                $participants[] = [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                ];
            }
        }
        if(count($participants)==0)
        {
            $statusMessage = 'Grupa została zaktualizowana!';
            return redirect()->route('home')->with([
                'status' => $statusMessage,
                'status_duration' => 2000, 
           
            ])->with('executeJs', true);
        }
        $event_details_id = $request->input('event_details_id');

       
        $NumberParticipants=count($participants);
        

        $result=$this->freeSeets($event_details_id,$NumberParticipants);
        if($result==1){
            
            $events->number_of_people += count($participants);
            $events->updated_at = now();
           
        
        
            
            $events->save();
            $eventDetails = EventDetails::find($event_details_id);
            $eventDetails->number_seats -= $NumberParticipants;
            $eventDetails->save();

            foreach ($participants as $participantData){
                $eventParticipantList = new EventParticipantList();
                $eventParticipantList->event_participants_id=$event_participant_id;
                $eventParticipantList->first_name= $participantData['first_name'];
                $eventParticipantList->last_name=$participantData['last_name'];
                $eventParticipantList->save();
                
            }
            $statusMessage = 'Grupa została zaktualizowana!';
            return redirect()->route('home')->with([
                'status' => $statusMessage,
                'status_duration' => 2000, 
              
            ])->with('executeJs', true);
        }
        

    }

    public function edit2(Request $request)
{
    $request->validate([
        'number_of_peoplee' => 'required|integer|min:1',
    ], [
        'number_of_peoplee.required' => 'Proszę wprowadzić liczbę.',
    ]);

    $event_participant_id = $request->input('id');

    $event_details_id = $request->input('event_details_id');
  
 

    $NumberParticipants = $request->input('number_of_peoplee');

 
    $result=$this->freeSeets($event_details_id,$NumberParticipants);
    if($result==1){
  
        $eventDetails = EventDetails::find($event_details_id);
        $eventDetails->number_seats -= $NumberParticipants;
        $eventDetails->save();

        $events = eventParticipant::find($event_participant_id);
        $events->number_of_people += $NumberParticipants;
        $events->updated_at = now();
        $events->save();

     

        $statusMessage = 'Dodano osoby do grupy!';
        return redirect()->route('home')->with([
            'status' => $statusMessage,
            'status_duration' => 2000,
           
        ])->with('executeJs', true);
    }
    else{
        $error = 'Nie ma już wolnych miejsc.';
       return redirect()->route('home')->withErrors(['status' => $error])->with('executeJs', true);
}
}


public function edit3(Request $request)
{
    $request->validate([
        'delete_people' => 'required|integer|min:1',
    ], [
        'delete_people.required' => 'Proszę wprowadzić liczbę.',
    ]);

    $event_participant_id = $request->input('id');

    $event_details_id = $request->input('event_details_id');
  


    $NumberParticipants = $request->input('delete_people');

 
    $result=$this->freeSeets3($event_details_id,$NumberParticipants,$event_participant_id);
    if($result==1){
        $eventDetails = EventDetails::find($event_details_id);
        $eventDetails->number_seats += $NumberParticipants;
        $eventDetails->save();

        $events = eventParticipant::find($event_participant_id);
        $events->number_of_people -= $NumberParticipants;
        $events->updated_at = now();
        $events->save();

     

        $statusMessage = 'Usunieto osoby z grupy!';
        return redirect()->route('home')->with([
            'status' => $statusMessage,
            'status_duration' => 2000,
       
        ])->with('executeJs', true);
    }
    else{
        $error = 'Nie możesz odjąć wiecej osób niż masz zapisanych.';
       return redirect()->route('home')->withErrors(['status' => $error])->with('executeJs', true);
}
    
}
    public function destroy($id){
        $currentDateTime = Carbon::now();
    
        $event_id = eventParticipantList::where('id', $id)->value('event_participants_id');
        $Parti_id = eventParticipant::where('id', $event_id)->value('event_details_id');
        eventParticipantList::where('id', $id)->update(['deleted_at' => $currentDateTime]);

        
        $eventParticipant = eventParticipant::find($event_id);
        $eventParticipant->number_of_people -= 1;
        $eventParticipant->save();


        $eventDetails = EventDetails::find($Parti_id);
        $eventDetails->number_seats += 1;
        $eventDetails->save();
        
    }
    
   public function delete($id)
{
    try {
        $currentDateTime = Carbon::now();

        $Parti_idd = eventParticipant::where('id', $id)->value('event_details_id');


        eventParticipant::where('id', $id)->update(['deleted_at' => $currentDateTime]);
  
        
        $hasDeletedAt = eventParticipantList::where('event_participants_id', $id)->whereNull('deleted_at')->exists();


        if ($hasDeletedAt) {
       
            $updatedCount = eventParticipantList::where('event_participants_id', $id)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => $currentDateTime]);
        }


        $numberOfPeople = eventParticipant::where('id', $id)->value('number_of_people');
        $eventDetails = EventDetails::find($Parti_idd);
        $eventDetails->number_seats += $numberOfPeople;
        $eventDetails->save();

        $statusMessage = 'Udało Ci się usunąć grupę!';
        return redirect()->route('home')->with('status', $statusMessage)->with('executeJs', true);

    } catch (\Exception) {
        $error = 'Wystąpił błąd podczas usuwania listy:';
        return redirect()->route('home')->withErrors(['status' => $error])->with('executeJs', true);
    }
}

    

    public function deletenr($id)
    {
        try {
            $currentDateTime = Carbon::now();
    
            $epa = eventParticipant::where('id', $id)->value('event_details_id');
    
            eventParticipant::where('id', $id)->update(['deleted_at' => $currentDateTime]);
            $number_of_people = eventParticipant::where('id', $id)->value('number_of_people');

            $eventDetails = EventDetails::find($epa);

            $eventDetails->number_seats += $number_of_people;
            $eventDetails->save();
    
             $statusMessage = 'Udało Ci się usunąć grupę!';
             return redirect()->route('home')->with('status', $statusMessage)->with('executeJs', true);

        } catch (\Exception) {

            $error = 'Wystąpił błąd podczas usuwania listy:';
        return redirect()->route('home')->withErrors(['status' => $error])->with('executeJs', true);
        }
    }
    public function leave($id){
        $userId=Auth::id(); 
        $currentDateTime = Carbon::now();
        eventParticipant::where('event_details_id', $id)
    ->where('participants_id', $userId)
    ->whereNull('number_of_people')
    ->update(['deleted_at' => $currentDateTime]);

    $eventDetails = EventDetails::where('id', $id)->first();
    if ($eventDetails) {
    $eventDetails->update(['number_seats' => $eventDetails->number_seats + 1]);
    return new JsonResponse(['success' => true, 'message' => 'Udało się wypisać z wydarzenia!']);
}
}
}
