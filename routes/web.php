<?php

use App\Http\Controllers\DictionarySchoolController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;

use App\Http\Controllers\EventGroupController;
use App\Http\Controllers\eventParticipantController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes(['verify'=>true]);
Route::get('/event/list',[EventController::class,'index'])->name('event.list');

Route::middleware(['auth','verified'])->group(function(){

Route::get('/szkola', [DictionarySchoolController::class, 'showForm']);

Route::post('/szkola', [DictionarySchoolController::class, 'schollssave']);

Route::get('/szkola-edit', [DictionarySchoolController::class, 'edit'])->name('szkola.edit');

Route::post('/szkola-edit', [DictionarySchoolController::class, 'update']);

Route::get('/leave/{entryId}',[eventParticipantController::class,'leave']);
Route::post('/signup', [eventParticipantController::class, 'signup']);



Route::get('/zapisz/{id}',[eventParticipantController::class,'zapisz'])->name('zapisz');
Route::get('/zapisznr/{id}',[eventParticipantController::class,'zapisznr'])->name('zapisznr');
Route::post('/zapisz',[eventParticipantController::class,'store']);
Route::post('/zapisznr',[eventParticipantController::class,'storenr']);

Route::get('/list/{id}',[eventParticipantController::class,'list'])->name('list');
Route::get('/listnr/{id}',[eventParticipantController::class,'listnr'])->name('listnr');


Route::post('/edit',[eventParticipantController::class,'edit']);
Route::post('/edit2',[eventParticipantController::class,'edit2']);
Route::post('/edit3',[eventParticipantController::class,'edit3']);


Route::delete('list/{id}', [eventParticipantController::class, 'destroy']);

Route::delete('event-details/{id}', [eventParticipantController::class, 'delete']);
Route::get('/events/search', [EventController::class,'search'])->name('events.search');

Route::delete('list-xd/{id}', [eventParticipantController::class, 'delete']);

Route::delete('listnr-nr/{id}', [eventParticipantController::class, 'deletenr']);


Route::get('/participant/edit/{id}', [ParticipantController::class, 'edit'])->name('participant.edit');
Route::post('/participant/{id}/update', [ParticipantController::class, 'updateProfile'])->name('participant.updateProfile');


Route::get('/change-password', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('change-password');
Route::post('/change-password', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('update-password');

});