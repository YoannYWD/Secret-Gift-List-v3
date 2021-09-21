<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Gift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GiftController extends Controller
{
    //AFFICHAGE ACCUEIL
    public function index() {
        $users = User::with('comments')->get();
        return view('gifts/index', compact('users'));
    }

    //AFFICHAGE PAGE CREATE + LISTE CADEAUX
    public function create(Request $request) {
        $for_user_id = $request->for_user_id;
        $gifts = DB::table('gifts')
                    ->join('users', 'gifts.posted_by_user_id', '=', 'users.id')
                    ->select('gifts.id', 'gifts.name', 'gifts.price', 'gifts.description', 'gifts.image', 'gifts.posted_by_user_id', 'gifts.created_at', 'users.nickname as user_nickname', 'users.image as user_image')
                    ->where('gifts.for_user_id', '=', $for_user_id)
                    ->get();
        $grantee = DB::table('users')
                    ->select('users.id', 'users.nickname')
                    ->where('users.id', '=', $for_user_id)
                    ->get();
        $wishes = DB::table('users')
                    ->select('users.wish1', 'users.wish2', 'users.wish3', 'users.wish4', 'users.wish5')
                    ->where('users.id', '=', $for_user_id)
                    ->get();
        return view('gifts/create', compact('for_user_id', 'gifts', 'grantee', 'wishes'));
    }

    //ENREGISTREMENT CADEAU
    public function store(Request $request) {
        $imageName = "";
        if ($request->image) {
            $imageName = time() . "." . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }
        $newGift = new Gift;
        $newGift->name = $request->name;
        $newGift->price = $request->price;
        $newGift->description = $request->description;
        $newGift->image = '/images/' . $imageName;
        $newGift->posted_by_user_id = auth()->id();
        $newGift->for_user_id = $request->for_user_id;
        $newGift->save();
    
        return back()
                         ->with('success', 'Cadeau enregistré !')
                         ->with('image', $imageName);
    }

    //AFFICHAGE PAGE EDITER
    public function edit(Request $request, $id) {
        $for_user_id = $request->for_user_id;
        $gift = Gift::findOrFail($id);
        return view('gifts.edit', compact('gift', 'for_user_id'));
    }

    //ENREGISTREMENT DES MODIFICATIONS 
    public function update(Request $request, $id) {
        $updateGift = $request->validate([
            'name' => 'required'
        ]);
        $updateGift = $request->except(['_token', '_method']);

        if ($request->image) {
            $imageName = time() . "." . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $updateGift['image'] = '/images/' . $imageName;
        }
        
        Gift::whereId($id)->update($updateGift);
        return back()->with('success', 'Cadeau modifié !');
    }


    //SUPPRESSION DU CADEAU
    public function destroy($id) {
        $gift = Gift::findOrFail($id);
        $gift->delete();
        return back()->with('success', 'Cadeau supprimé !');
    }

}
