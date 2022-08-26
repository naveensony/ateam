<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function check(Request $request)
    {
        $invitations = Invitation::where('event_id',$request->event)->where('email',$request->email)->first();
        if($invitations)
        {
            return response()->json(['success'=>"Invitee already exists."]);
        }

    }

    public function store(Request $request)
    {
        $input = $request->only('email', 'event_id');
        Invitation::create($input);

        ////send email to this id



        //////////////
        return response()->json(['success'=>"Invitee added."]);
    }

    public function index($id)
    {
        $html = '';
        $invitation = Invitation::where('event_id',$id)->get();
        if(count($invitation))
        {
            foreach($invitation as $key=>$inv)
            {
                $html .= '<tr><td>'.($key+1).'</td><td>';
                $html .= $inv->email.'</td><td><a id="" href="#" data-id="'.$inv->id.'" class="btn btn-danger btn-sm inv_delete">Delete</a></td></tr>';

            }
        }
        else{
            $html .= '<tr><td>No Invitees</td></tr>';
        }
        return $html;
    }

    public function delete($id)
    {
        Invitation::where('id',$id)->delete();
        return response()->json(['success'=>"Invitee deleted."]);
    }
}
