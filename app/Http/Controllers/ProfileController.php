<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    //AFFICHER LE PROFIL
    public function index() {
        $id = auth()->id();
        $user = DB::table('users')
                        ->select('users.id', 'users.lastname', 'users.firstname', 'users.nickname', 'users.email', 'users.image', 'users.wish1', 'users.wish2', 'users.wish3', 'users.wish4', 'users.wish5')
                        ->where('users.id', '=', $id)
                        ->get();
        $gifts = DB::table('gifts')
                        ->join('users', 'gifts.for_user_id', '=', 'users.id')
                        ->select('gifts.id', 'gifts.name', 'gifts.for_user_id', 'gifts.created_at', 'users.nickname as user_nickname')
                        ->where('gifts.posted_by_user_id', '=', $id)
                        ->get();
        return view('profile/index', compact('user', 'gifts'));
    }

    //MISE A JOUR DU PROFIL
    public function update(Request $request, $id) {
        $updateProfile = $request->validate([
            'lastname' => 'required',
            'firstname' => 'required',
            'nickname' => 'required',
            'email' => 'required'
        ]);
        $updateProfile = $request->except(['_token', '_method']);

        if ($request->image) {
            $imageName = time() . "." . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $updateProfile['image'] = '/images/' . $imageName;
        }
        
        User::whereId($id)->update($updateProfile);
        return back()->with('success', 'Profil modifié !');
    }
}
