<?php

namespace App\Http\Controllers;

use App\Models\EventDetails;
use App\Models\eventParticipant;
use Illuminate\Support\Facades\Auth;
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

    public function signup(Request $request)
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
    
        $eventDetailsId = $request->input('event_details_id');
        $isSaved = $this->check($eventDetailsId);
        $availableSeats = $this->freeSeets($eventDetailsId);
    
        if ($isSaved == 1) {
            if ($availableSeats == 1) {
                $eventId = $request->input('event_id');
    
                try {
                    DB::transaction(function () use ($eventId, $eventDetailsId) {
                        $eventUser = new eventParticipant();
                        $eventUser->date_report = now();
                        $eventUser->dictionary_schools_id = 1;
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


    public function addParticipants(Request $request)
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

    $eventDetailsId = $request->input('event_details_id');
    $isSaved = $this->check($eventDetailsId);
    $availableSeats = $this->freeSeets($eventDetailsId);

    if ($isSaved == 1) {
        $numberOfPeople = $request->input('number_of_people'); 

        if ($availableSeats >= $numberOfPeople) {
            $eventId = $request->input('event_id');
            $groupData = $request->input('group_data');

            try {
                DB::transaction(function () use ($eventId, $eventDetailsId, $participantId, $numberOfPeople, $groupData) {
                    $eventUser = new eventParticipant();
                    $eventUser->date_report = now();
                    $eventUser->dictionary_schools_id = 1;
                    $eventUser->participants_id = $participantId;
                    $eventUser->events_id = $eventId;
                    $eventUser->event_details_id = $eventDetailsId;
                    $eventUser->number_of_people = $numberOfPeople; 
                    $eventUser->save();

                    $eventDetails = EventDetails::find($eventDetailsId);
                    $eventDetails->number_seats -= $numberOfPeople;
                    $eventDetails->save();

                    foreach ($groupData as $userData) {
                        $eventParticipantList = new eventParticipantList();
                        $eventParticipantList->event_participants_id = $eventUser->id;
                        $eventParticipantList->first_name = $userData['first_name'];
                        $eventParticipantList->last_name = $userData['last_name'];
                        $eventParticipantList->save();
                    }
                });

                $statusMessage = 'Udało Ci się zapisać grupę na wydarzenie!';
                return redirect()->route('event.list')->with('status', $statusMessage);
            } catch (\Exception $e) {
                $error = 'Wystąpił problem podczas zapisywania. Spróbuj ponownie.';
                return redirect()->route('event.list')->withErrors(['message' => $error]);
            }
        } else {
            $error = 'Nie ma wystarczającej liczby wolnych miejsc.';
            return redirect()->route('event.list')->withErrors(['message' => $error]);
        }
    } else {
        $error = 'Jesteś już zapisany/a.';
        return redirect()->route('event.list')->withErrors(['message' => $error]);
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
