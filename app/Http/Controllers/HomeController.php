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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $participantId = Auth::id();
        $result = DB::table('event_participants')
        ->join('events', 'event_participants.events_id', '=', 'events.id')
        ->join('event_details', 'event_participants.event_details_id', '=', 'event_details.id')
        ->where('event_participants.participants_id', $participantId)
        ->whereNull('event_participants.delated_at')
        ->select('events.name', 'event_details.title','event_participants.id')
        ->get();


        return view('home', ['results' => $result]);

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
