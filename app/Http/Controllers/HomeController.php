<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\EventParticipant;
use App\Models\Event;
use App\Models\EventDetails;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function school($id){
        $participant = DB::table('participants')
                ->where('id', $id)
                ->whereNotNull('dictionary_schools_id')
                ->first();

        if ($participant) {
            return 1;
        } else {
            return 0;
        }

    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   public function index()
{
    $participantId = Auth::id();
    $participant = Participant::findOrFail($participantId);

    $results = DB::table('event_participants')
        ->join('events', 'event_participants.events_id', '=', 'events.id')
        ->join('event_details', 'event_participants.event_details_id', '=', 'event_details.id')
        ->where('event_participants.participants_id', $participantId)
        ->whereNull('event_participants.deleted_at')
        ->whereNull('event_participants.number_of_people')
        ->select('event_details.title', 'event_details.date_start', 'event_details.date_end', 'event_details.description', 'event_participants.id','event_details.id')
        ->orderBy('event_details.date_start', 'asc')
        ->get();

    foreach ($results as $result) {
        $result->date_start = Carbon::parse($result->date_start);
        $result->date_end = Carbon::parse($result->date_end);
    }

    $groups = DB::table('event_participants')
    ->join('events', 'event_participants.events_id', '=', 'events.id')
    ->join('event_details', 'event_participants.event_details_id', '=', 'event_details.id')
    ->where('event_participants.participants_id', $participantId)
    ->whereNull('event_participants.deleted_at')
    ->whereNotNull('event_participants.number_of_people')
    ->select('event_details.title', 'event_details.date_start', 'event_details.date_end', 'event_details.speaker_first_name','event_details.speaker_last_name','event_details.description', 'event_participants.id as participant_id','event_participants.number_of_people','event_details.id','event_participants.created_at','event_details.type')
    ->orderBy('event_details.date_start', 'asc')
    ->get();


    foreach ($groups as $group) {
        $group->date_start = Carbon::parse($group->date_start);
        $group->date_end = Carbon::parse($group->date_end);
    }

    $numeric = DB::table('event_participants')
        ->join('events', 'event_participants.events_id', '=', 'events.id')
        ->join('event_details', 'event_participants.event_details_id', '=', 'event_details.id')
        ->where('event_participants.participants_id', $participantId)
        ->whereNull('event_participants.deleted_at')
        ->whereNotNull('event_participants.number_of_people')
        ->select('event_details.title', 'event_details.date_start', 'event_details.date_end', 'event_details.description', 'event_participants.id as participant_id','event_details.number_seats','event_details.id','event_participants.created_at','event_details.type')
        ->orderBy('event_details.date_start', 'asc')
        ->get();

    foreach ($numeric as $liste) {
        $liste->date_start = Carbon::parse($liste->date_start);
        $liste->date_end = Carbon::parse($liste->date_end);
    }

    $checkSchool = $this->school($participantId);

    return view('home', [
        'results' => $results,
        'groups' => $groups,
        'numeric' => $numeric,
        'participant' => $participant,
        'error' => ($checkSchool == 1) ? null : 'Proszę uzupełnić szkołę!'
    ]);
}

    

    public function changePassword()
    {
        return view('change-password');
    }
    public function updatePassword(Request $request)
{
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->with("error", "Stare hasło jest niepoprawne!");
        }


        #Update the new Password
        Participant::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Udało się!");
}

}
