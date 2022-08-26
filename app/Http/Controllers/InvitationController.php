<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Mail;

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
           $this->sent($request->email);


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

    public function sent($email)
    {
        
        ////send email to this id
       
        try
        {
            $data = array('name'=>"User");
            Mail::send(['text'=>'mail'], $data, function($message) use ($email) {
                $message->to($email, 'Ateam')->subject
                   ('You are invited for the event');
                $message->from(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'));
             });
        }
        catch (\Exception $e)
        {
            return $e;
        }
        
    }
}
