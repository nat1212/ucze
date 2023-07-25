<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        $result = DB::table('event_participants')
        ->join('events', 'event_participants.events_id', '=', 'events.id')
        ->join('event_details', 'event_participants.event_details_id', '=', 'event_details.id')
        ->where('event_participants.participants_id', $participantId)
        ->whereNull('event_participants.deleted_at')
        ->select('events.name', 'event_details.title','event_details.date_start', 'event_details.date_end', 'event_participants.id')
        ->orderBy('event_details.date_start', 'asc')
        ->get();

        $checkSchool = $this->school($participantId);
        if ($checkSchool == 1) {
            return view('home', ['results' => $result,'participant'=> $participant,'error' => null]);
        } else {
            return view('home', ['results' => $result,'participant'=> $participant, 'error' => 'Proszę uzupełić szkołę!']);
        }
       

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
