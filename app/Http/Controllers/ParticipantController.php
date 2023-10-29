<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Casts\AsDateTime;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
class ParticipantController extends Controller
{
    public function edit($id)
{
    $participant = Participant::findOrFail($id);
    return view('home', compact('participant'));
}



public function updateProfile(Request $request, $id)
{
    $participant = Participant::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'first_name' => 'nullable|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'sex' => ['nullable', Rule::in(['m', 'k', 'n'])],
    
    ]);

    if ($validator->fails()) {
        return new JsonResponse(['message' => 'Wystąpił błąd podczas aktualizacji danych.']);
    }

    $dataToUpdate = [];
    if (!empty($request->first_name)) {
        $dataToUpdate['first_name'] = $request->first_name;
    }

    if (!empty($request->last_name)) {
        $dataToUpdate['last_name'] = $request->last_name;
    }

    if (!empty($request->sex)) {
        $dataToUpdate['sex'] = $request->sex;
    }


    $participant->update($dataToUpdate);

    return new JsonResponse(['success' => true, 'message' => 'Profil został zaktualizowany.']);
}

}