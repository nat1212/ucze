<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\EventDetails;
use App\Models\Event;
use Illuminate\Contracts\View\View;


class EventDetailsController extends Controller
{
   
    
    /**
     * Display the specified resource.
     *
     * @param  Event $event
     * @return View
     */
    public function create2($id) : View
    {
        return view('create2',[
            'event' => $id
          ]);
    }
      /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       *@return RedirectResponse
       */
      public function store(Request $request):RedirectResponse
      {
          EventDetails::create($request->all());
          
          return redirect()->route('event.list');
          
      }
}
