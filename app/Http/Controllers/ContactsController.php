<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as InertiaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Models\ContactInvite;
use Illuminate\Support\Facades\Mail;
use App\Mail\InviteContact;
use App\Models\ContactLists;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendUserNotification;
use App\Notifications\InviteContacts;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('Create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'user_id' => 'required|max:255',
                'email' => 'required|email:rfc,dns'
            ],
            [
                'user.required' => 'User Id is required',
                'user.email' => 'Email address is required',
            ]
        );

        $id = Auth::id();
        $user = User::where('id', $id)->first();

        // check email if exist
        $inviteUser = User::where('email', $request->input('email'))->first();

        // check if already sent the email invite
        $inviteRequest = ContactInvite::where('email', $request->input('email'))
                ->where('user_id', $user->id)
                ->first();

        if($inviteRequest) {
            return response()->json(['status' => true, 'message' => 'Already sent an invitation']);
        }

        if($inviteUser) {
            $contactList = ContactLists::where('user_id', $user->id)
                                ->where('contact_id', $inviteUser->id)
                                ->first();
        
            if($contactList) {
                return response()->json(['status' => true, 'message' => 'Contact already added']);
            }
        }

        if($inviteUser) {
            // end direct notification invite
            // create invite link and send to email
            $data = [
                'user_id'       => $id,
                'contact_id'    => $inviteUser->id,
                'email'         => $request->input('email'),
                'direct_invite' => 1,
                'status'        => 1
            ];

            $contactInvite = ContactInvite::create($data);
            // create contact list record
            ContactLists::create(['user_id' => $id, 'contact_id' => $inviteUser->id, 'status' => 1]);
            // send notification
            $contactInvite->name = $user->name;
            Notification::send($inviteUser, new SendUserNotification($contactInvite));
            return response()->json(['status' => true, 'message' => "Sent invitation for contact. Invite will be on the user's notification page."]);
        }

        
        // create invite link and send to email
        $data = [
            'user_id'       => $id,
            'email'         => $request->input('email'),
            'invite_link'   => md5(time()."$id")
        ];


        $contact = ContactInvite::create($data);
        $data['url'] = $url = route('register')."?invite_link=".$data['invite_link'];
        $data['name'] = $user->name;
        $user->email = $data['email'];
        // $user->email = $data['email'];

        // Mail::to($request->input('email'))->send(new InviteContact($user));
        Notification::send($user, new InviteContacts($data));
        return response()->json(['status' => true, 'message' => 'Sent invitation via email for contact']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
