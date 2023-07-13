<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Event;

class EventController extends Controller
{
    public function index(): View
    {
        return view('event.list' ,
        [

        'events' => Event::paginate(2)

        ]);
    }
  

}
