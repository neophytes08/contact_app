<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use App\Models\ContactInvite;
use App\Models\ContactLists;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        
        $inviteLink = $request->input('invite_link') ?? null;
        
        // get invite contact data
        $data = $inviteLink ? ContactInvite::where('invite_link', $inviteLink)->select('user_id', 'invite_link', 'email')->first() : null;

        return Inertia::render('Auth/Register', ['invite_data' => $data]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'city' => $request->city,
            'address' => $request->address,
            'country' => $request->country,
            'password' => Hash::make($request->password),
            'photo' => 'https://st.depositphotos.com/1779253/5140/v/600/depositphotos_51405259-stock-illustration-male-avatar-profile-picture-use.jpg'
        ]);
        
        if($request->input('user_id')) {
            // create
            $data = [
                'user_id'       => $request->input('user_id'),
                'contact_id'    => $user->id,
                'status'        => 1
            ];

            ContactLists::create($data);
            ContactInvite::where('email', $request->input('email'))->update(['status' => 1]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
