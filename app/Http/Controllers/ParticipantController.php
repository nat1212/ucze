<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Casts\AsDateTime;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Http\Controllers\Controller;

class ParticipantController extends Controller
{
    public function edit($id)
{
    $participant = Participant::findOrFail($id);
    return view('home', compact('participant'));
}

protected $casts = [

    'birth_date' => 'datetime',
];


public function updateFirstName(Request $request, $id)
{
    $participant = Participant::findOrFail($id);
    $participant->update(['first_name' => $request->first_name]);

    return redirect()->route('home')->with('status', 'Imię zostało zaktualizowane.');
}

public function updateLastName(Request $request, $id)
{
    $participant = Participant::findOrFail($id);
    $participant->update(['last_name' => $request->last_name]);

    return redirect()->route('home')->with('status', 'Nazwisko zostało zaktualizowane.');
}

public function updateSex(Request $request, $id)
{
    $participant = Participant::findOrFail($id);
    $participant->update(['sex' => $request->sex]);

    return redirect()->route('home')->with('status', 'Płeć zostało zaktualizowane.');
}

public function updateBirthDate(Request $request, $id)
{
    $participant = Participant::findOrFail($id);
    $participant->update(['birth_date' => $request->birth_date]);

    return redirect()->route('home')->with('status', 'Data urodzenia zostało zaktualizowane.');
}

}