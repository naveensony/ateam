<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
   public function index(Request $request)
   {
    
    $events = Event::query();
    if($request->has('search') && $request->search != '')
    {
        $events = $events->where('name','like','%'.$request->search.'%');
    }
    if($request->has('start_date') && $request->start_date != '')
    {
        $events = $events->whereDate('start_date','>=',$request->start_date);
    }
    if($request->has('end_date') && $request->end_date != '')
    {
        $events = $events->whereDate('end_date','<=',$request->end_date);
    }
    
    $events = $events->latest()->paginate(2);
    return view('welcome',compact('events'));
   }

   public function details()
   {
    $average = DB::table('events')->select(DB::raw("COUNT('*') as total_count"),DB::raw("COUNT('*')/COUNT(DISTINCT `created_by`) as average"))->first();
    $users = Event::select('created_by', DB::raw("COUNT(*)  as total"))->groupBy('created_by')->get();
    return view('details',compact('average','users'));
   }
}
