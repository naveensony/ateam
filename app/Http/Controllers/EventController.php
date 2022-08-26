<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $events = Event::where('created_by',Auth::user()->id)->latest()->get();
        return view('event.dashboard',compact('events'));
    }

    public function store(Request $request)
    {
        $input = $request->only('name', 'start_date', 'end_date');
        $input['created_by'] = Auth::user()->id;
        Event::create($input);
        return true;
    }
    public function delete($id)
    {
        $invities = Invitation::where('event_id',$id)->first();
        if($invities)
        {
            return redirect()->route('dashboard')->with('status','Please deleted invities before deleting the event!');
        }
        $event = Event::where('id',$id)->delete();
        return redirect()->route('dashboard')->with('status','Event Deleted');
    }
}
