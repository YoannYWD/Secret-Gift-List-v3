<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    //
    public function index() {
        return view('auth.login');
    }

    public function userLogin(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/accueil')
                             ->with('success', 'Tu es connecté ! Bonjour ' . Auth::user()->nickname);
        }

        return redirect('/login')->with('alert', 'Ton email ou mot de passe est incorrect.');
    }

    public function registration() {
        return view('auth.registration');
    }

    public function userRegistration(Request $request) {
        $request->validate([
            'lastname' => 'required',
            'firstname' => 'required',
            'nickname' => 'required',
            'email' => 'required|email|unique:users',
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            'password' => [
                'required',
                'string',
                'min:8',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
        ]);

        $data = $request->all();
        $this->createUser($data);

        return redirect('/login')->with('success', 'Tu es enregistré !');
    }

    public function createUser(array $data) {
        $request = request();
        $imageName = "";
        $imageName = time() . "." . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $request->image = '/images/' . $imageName;

        return User::create([
            'lastname' => $data['lastname'],
            'firstname' => $data['firstname'],
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'image' => $request->image,
            'password' => Hash::make($data['password'])
        ]);
    }

    /*public function dashboard() {
        if(Auth::check()) {
            return view('groups/index');
        }
        return redirect('auth/login')->with('alert', "Vous n'êtes pas connecté.");
    }*/

    public function signOut() {
        Session::flush();
        Auth::logout();

        return redirect('/accueil');
    }
}