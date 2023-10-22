<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DictionarySchool;
use Illuminate\Support\Facades\Auth;
use App\Models\Participant;

class DictionarySchoolController extends Controller
{
    public function showForm()
    {
        $schools = DictionarySchool::all(); // Zakładając, że nazwa modelu to "DictionarySchool"
        return view('/szkola')->with('schools', $schools);
    }

    public function schollssave(Request $request)
    {
        $participantId = Auth::id();
        $schollName = $request->input('name');
        $dictionarySchool = DictionarySchool::where('name', $schollName)->first();
        

        $participant = Participant::find($participantId);
        $participant->dictionary_schools_id = $dictionarySchool->id;
        $participant->save();


        $statusMessage = 'Udało Ci się dodać szkołę!';
        return redirect()->route('home')->with('status', $statusMessage);

        
    }
    
}
