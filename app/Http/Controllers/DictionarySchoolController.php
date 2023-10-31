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
        $dictionarySchool = DictionarySchool::whereRaw("CONCAT(name, ' ul.', street, ' ', zip_code) = ?", [$schollName])->first();
        
        if ($dictionarySchool) {
        $participant = Participant::find($participantId);
        $participant->dictionary_schools_id = $dictionarySchool->id;
        $participant->save();


        $statusMessage = 'Udało Ci się dodać szkołę!';
        return redirect()->route('home')->with('status', $statusMessage);
    } else {
        $statusMessage = 'Nie można znaleźć szkoły o podanym opisie.';
        return redirect()->route('home')->withErrors(['status' => $statusMessage]);
    }
        
    }

    public function edit()
{
    $schools = DictionarySchool::all();
    return view('/szkola-edit', ['schools' => $schools]);
}

public function update(Request $request)
{
    $participantId = Auth::id();
    $schoolDescription = $request->input('name'); 

   
    $dictionarySchool = DictionarySchool::whereRaw("CONCAT(name, ' ul.', street, ' ', zip_code) = ?", [$schoolDescription])->first();

    if ($dictionarySchool) {
   
        $participant = Participant::find($participantId);

        if ($participant->dictionary_schools_id == $dictionarySchool->id) {
       
            return redirect()->route('home')->withErrors(['status' => 'Jesteś już zapisany do tej szkoły.']);
        } else {
     
            $participant->dictionary_schools_id = $dictionarySchool->id;
            $participant->save();

            $statusMessage = 'Szkoła została zaktualizowana.';
            return redirect()->route('home')->with('status', $statusMessage);
        }
    } else {
        $statusMessage = 'Nie można znaleźć szkoły o podanym opisie.';
        return redirect()->route('home')->withErrors(['status' => $statusMessage]);
    }
}




    
}
