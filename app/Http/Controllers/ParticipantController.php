<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Casts\AsDateTime;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
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

    $user = Auth::user();

    $validator = Validator::make($request->all(), [
        'first_name' => 'nullable|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'email' => ['nullable', 'string', 'max:255', 'email'],
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

    if (!empty($request->email)) {
        $newEmail = $request->email;
        if ($newEmail != $participant->email || $newEmail != $user->email) {

            $existingParticipant = Participant::where('email', $newEmail)->first();
            $existingUser = User::where('email', $newEmail)->first();
            if ($existingParticipant ||  $existingUser) {
                return new JsonResponse(['message' => 'Adres e-mail jest już zajęty.']);
            } else {
                $dataToUpdate['email'] = $newEmail;
                $dataToUpdate['email_verified_at'] = null;
                $participant->update($dataToUpdate);
                $participant->sendEmailVerificationNotification($newEmail);
            }
        }
    }

    if (!empty($request->sex)) {
        $dataToUpdate['sex'] = $request->sex;
    }

    $participant->update($dataToUpdate);

    return new JsonResponse(['success' => true, 'message' => 'Profil został zaktualizowany.']);
}
}