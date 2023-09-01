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




Route::get('/szkola', [DictionarySchoolController::class, 'showForm']);

Route::post('/szkola', [DictionarySchoolController::class, 'schollssave']);

Route::get('/event/list',[EventController::class,'index'])->name('event.list');
Route::get('/leave/{entryId}',[eventParticipantController::class,'leave']);
Route::post('/signup', [eventParticipantController::class, 'signup']);


Route::post('/add_group_submit',  [EventGroupController::class,'add_group_submit'])->name('add_group_submit');
Route::get('/add_group',[EventGroupController::class,'addGroup'])->name('add_group');




Route::get('/events/search', [EventController::class,'search'])->name('events.search');
Auth::routes(['verify'=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/participant/edit/{id}', [ParticipantController::class, 'edit'])->name('participant.edit');
Route::post('/participant/{id}/update', [ParticipantController::class, 'updateProfile'])->name('participant.updateProfile');


Route::get('/change-password', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('change-password');
Route::post('/change-password', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('update-password');

