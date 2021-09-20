@extends('app')

@section('title')
Commentaires {{$gift[0]->name}}
@endsection
@section('description', "Discutez autour du cadeaux que vous souhaitez offrir, à l'utilisateur que vous avez choisi. Optimisez vos chances de le rendre heureux !")


@section('content')

<!-- BOUTON RETOUR PAGE LISTE DES CADEAUX DU BENEFICIAIRE SELECTIONNE -->
<div class="container">
    <div class="row text-center">
        <form action="{{route('accueil.create')}}" method="GET">
            @csrf
            <input type="hidden" name="for_user_id" value="{{$gift[0]->for_user_id}}">
            <button type="submit" class="btn btnGreen">Retourner à la liste</button>
        </form>
        <p class="intro mt-5">Tu es arrivé dans l'espace <span class="yellow">salon</span>. C'est ici que se décident les plus beaux <span class="green">secrets</span> qui raviront les chanceux !</p>
    </div>
</div>

<!-- AFFICHAGE DU CADEAU A COMMENTER -->
<div class="container">
    <div class="row mt-5 mb-4">
        <div class="col-10 offset-1">
            <div class="card commentGiftCard">
                <div class="row">
                    <div class="col-3">
                        <img src="{{$gift[0]->image}}" class="card-img-top" alt="Image de {{$gift[0]->name}}" style="height: 18rem;">
                    </div>
                    <div class="col-7">
                        <div class="card-body">
                            <h5 class="card-title">{{$gift[0]->name}}</h5>
                            <p><span class="blue">{{$gift[0]->price}}€</span></p>
                            <p>{{$gift[0]->description}}</p>
                        </div>
                        <div class="card-footer">
                            <p class="text-muted small mb-0"><img class="mr-3 rounded-circle me-2" src="{{$gift[0]->user_image}}" alt="Generic placeholder image" style="max-width:50px"><i class="far fa-user pe-1"></i>{{$gift[0]->user_nickname}}<i class="far fa-calendar-alt ps-3 pe-1"></i> {{ \Carbon\Carbon::parse($gift[0]->created_at)->translatedFormat('d F Y à H\hi') }}</p>
                            <p class="text-muted small mb-0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    
    <!-- AFFICHAGE DES COMMENTAIRES / EDITION PAR MODAL -->
    <div class="row mb-1">
        @foreach($comments as $comment)
        <div class="col-10 offset-1 mb-1">
            <div class="card comment">
                <div class="row">
                    <div class="col-1 d-flex align-self-center justify-content-center mt-1">
                        <img class="mr-3 rounded-circle" src="{{$comment->user_image}}" alt="Generic placeholder image" style="max-width:50px">
                    </div>
                    <div class="col-11">
                        <p class="mt-2">{{$comment->content}}</i></p>
                        
                        <div class="row d-flex align-items-end">
                            <div class="col-9">
                                <p class="text-muted extraSmall mb-0"><i class="far fa-user pe-1"></i>{{$gift[0]->user_nickname}} <i class="far fa-calendar-alt ps-3 pe-1"></i>{{ \Carbon\Carbon::parse($comment->created_at)->translatedFormat('d F Y à H\hi') }}</p>
                            </div>
                            @if($comment->user_id == auth()->id())
                            <div class="col-1">
                                <button type="submit" class="btn btnEditExtraSmall py-0 px-1" data-bs-toggle="modal" data-bs-target="#exampleModal{{$comment->id}}">Modifier</button>                           
                            </div>
                            <div class="col-1">
                                <form action="{{route('commentaires.destroy', $comment->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btnDeleteExtraSmall py-0 px-1">Supprimer</a>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>


            <!-- Modal -->
            <div class="modal fade" id="exampleModal{{$comment->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><span class="yellow">Modifie</span> ton commentaire : </h5>
                        </div>
                        <form action="{{route('commentaires.update', $comment->id)}}" method="POST">
                            <div class="modal-body">
                                <textarea type="text" name="content" placeholder="Modifiez votre commentaire" rows="3" cols="42" value="{{$comment->content}}"></textarea>
                            </div>
                            <div class="modal-footer">
                                @csrf
                                @method('PATCH')                        
                                <button type="button" class="btn btnRed" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btnGreen">Modifier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        @endforeach
    </div>
</div>

<!-- AJOUTER UN COMMENTAIRE -->
<div class="container mt-4">
    <div class="row">
        <div class="col-10 offset-1">
            <form method="POST" action="{{route('commentaires.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                  <label>Votre commentaire</label>
                  <textarea type="text" name="content" class="form-control" rows="3" placeholder="Lachez votre plus beau com'"></textarea>
                </div>
                <input type="hidden" value="{{$gift[0]->id}}" name="id">
                <button type="submit" class="btn btnGreen">Enregistrer</button>
            </form>
        </div>
    </div>
</div>











@endsection