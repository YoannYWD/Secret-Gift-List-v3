<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    //AFFICHER PAGE CREATE
    public function create(Request $request) {
        $gift_id = $request->gift_id; 
        $gift = DB::table('gifts')
                    ->join('users', 'gifts.posted_by_user_id', '=', 'users.id')
                    ->select('gifts.id', 'gifts.name', 'gifts.price', 'gifts.description', 'gifts.image', 'gifts.posted_by_user_id', 'gifts.for_user_id as for_user_id', 'gifts.created_at', 'users.nickname as user_nickname', 'users.image as user_image')
                    ->where('gifts.id', '=', $gift_id)
                    ->get();
        $comments =  DB::table('comments')
                        ->join('users', 'users.id', '=', 'comments.user_id')
                        ->join('gifts', 'gifts.id', '=', 'comments.gift_id')
                        ->select('comments.id', 'comments.content', 'comments.user_id', 'comments.created_at', 'users.nickname as user_nickname', 'users.image as user_image')
                        ->where('comments.gift_id', '=', $gift_id)
                        ->get();    
        return view('comments/create', compact('gift', 'comments'));
    }

    //ENREGISTRER LE COMMENTAIRE
    public function store(Request $request) {
        $newComment = new Comment;
        $newComment->content = $request->content;
        $newComment->user_id = auth()->id();
        $newComment->gift_id = $request->id;
        $newComment->save();
        return back()->with('success', 'Commentaire enregistré !');
    }

    //AFFICHAGE EDITER UN COMMENTAIRE
    public function edit(Request $request, $id) {
        $gift_id = $request->gift_id;
        $comment = Comment::findOrFail($id);
        return view('comments.create', compact('comment'));
    }

    //MISE A JOUR DU COMMENTAIRE
    public function update(Request $request, $id) {
        $updateComment = $request->validate([
            'content' => 'required'
        ]);
        Comment::whereId($id)->update($updateComment);
        return back()->with('success', 'Commentaire modifié !');
    }

    //SUPPRIMER UN COMMENTAIRE
    public function destroy($id) {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return back()->with('success', 'Commentaire supprimé !');
    }
}
