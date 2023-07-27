<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Casts\AsDateTime;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $participant->update(['first_name' => $request->first_name]);

        return redirect()->route('home')->with('status', 'Imię zostało zaktualizowane.');
    }

    public function updateLastName(Request $request, $id)
    {
        $participant = Participant::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'last_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $participant->update(['last_name' => $request->last_name]);

        return redirect()->route('home')->with('status', 'Nazwisko zostało zaktualizowane.');
    }

    public function updateSex(Request $request, $id)
    {
        $participant = Participant::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'sex' => ['required', Rule::in(['m', 'k', 'n'])],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $participant->update(['sex' => $request->sex]);

        return redirect()->route('home')->with('status', 'Płeć została zaktualizowana.');
    }

    public function updateBirthDate(Request $request, $id)
    {
        $participant = Participant::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'birth_date' => 'required', 'date', 'before_or_equal:2010-01-01',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $participant->update(['birth_date' => $request->birth_date]);

        return redirect()->route('home')->with('status', 'Data urodzenia została zaktualizowana.');
    }

}