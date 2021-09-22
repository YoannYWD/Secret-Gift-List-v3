@extends('app')

@section('title')
Cadeaux pour {{$grantee[0]->nickname}}
@endsection

@section('description', "Proposez le cadeaux que vous souhaitez offrir, à l'utilisateur que vous avez choisi. Découvrez sa wishlist et les cadeaux déjà proposés !")

@section('content')

<!-- FORMULAIRE CREATION NOUVEAU CADEAU -->

<div class="container darkBlue py-5">
    <div class="row">
        <p class="intro mb-5">Tu trouveras ci dessous plusieurs <span class="yellow">choses</span> : un formulaire pour <span class="blue">proposer</span> un cadeau que tu pourras modifier ou supprimer dans ton profil, la <span class="red">wishlist</span> de {{$grantee[0]->nickname}}, et plus bas la liste de tous les <span class="green">cadeaux</span> proposés !</p>
    </div>
</div>

<div class="container-fluid white">
    <div class="container py-5">
        <div class="row">
            <!-- AFFICHAGE SOUHAITS -->
            <div class="col-md-6 mb-5">
                <p class="introSmall">La <span class="red">wishlist</span> de {{$grantee[0]->nickname}} :</p>
                <div class="row">
                    <div class="col-12">
                        @foreach($wishes as $wish)
                        <p><i class="fas fa-gift me-3"></i> {{$wish->wish1}}</p>
                        <p><span class="blue"><i class="fas fa-gift me-3"></i></span> {{$wish->wish2}}</p>
                        <p><span class="red"><i class="fas fa-gift me-3"></i></span> {{$wish->wish3}}</p>
                        <p><span class="green"><i class="fas fa-gift me-3"></i></span> {{$wish->wish4}}</p>
                        <p><span class="yellow"><i class="fas fa-gift me-3"></i></span> {{$wish->wish5}}</p>
                        @endforeach
                    </div>
                </div>
            </div>
    
            <div class="col-md-6">
                <p class="introSmall"><span class="blue">Propose</span> un cadeau si tu le souhaites :</p>
                <form action="{{route('accueil.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- nom -->
                    <div class="form-group mb-3">
                        <input type="text" placeholder="Nom du cadeau" class="form-control" name="name">
                        @if($errors->has('name'))
                        <span class="text-danger">{{$errors->first('name')}}</span>
                        @endif
                    </div>
    
                    <!-- prix -->
                    <div class="form-group mb-3">
                        <input type="number" placeholder="Prix" class="form-control" name="price" min="0">
                        @if($errors->has('price'))
                        <span class="text-danger">{{$errors->first('price')}}</span>
                        @endif
                    </div>
    
                    <!-- description -->
                    <div class="form-group mb-3">
                        <input type="text" placeholder="Quelques infos supplémentaires" class="form-control" name="description">
                        @if($errors->has('description'))
                        <span class="text-danger">{{$errors->first('description')}}</span>
                        @endif
                    </div>
    
                    <!-- image -->
                    <div class="form-group mb-3">
                        <label for="formFile" class="form-label">Image</label>
                        <input class="form-control" type="file" name="image">
                        @if($errors->has('image'))
                        <span class="text-danger">{{$errors->first('image')}}</span>
                        @endif
                    </div>
    
                    <div class="d-grid mx-auto">
                        <input type="hidden" name="for_user_id" value="{{$for_user_id}}">
                        <button type="submit" class="btn btnGreenBgWhite btn-block">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- AFFICHAGE DE TOUS LES CADEAUX PROPOSES POUR CE BENEFICIAIRE -->

<div class="container darkBlue py-5">
    <div class="row mt-5">
    <h1 class="text-center mb-4">Cadeaux pour <span class="blue">{{$grantee[0]->nickname}}</span></h1>
        @foreach($gifts as $gift)
        <div class="col-md-6 col-xl-4 mt-3 mb-2">
            <div class="card giftCard text-center">

                <div class="col-12" style="background-image: linear-gradient(rgba(22, 27, 64, 0.8),rgba(22, 27, 64, 0.8)), url({{$gift->image}}); background-size: cover; background-repeat: no-repeat; height: 250px; background-position: 50% 50%; border-top-left-radius: 3px; border-top-right-radius: 3px">
                <div class="col-12" style="background-image: url({{$gift->image}}); background-size: contain; background-repeat: no-repeat; height: 250px; background-position: 50% 50%; border-top-left-radius: 3px; border-top-right-radius: 3px"></div>
                </div>
                <div class="card-body">
                    <h2 class="card-title">{{$gift->name}}</h2>
                    @if($gift->price)
                    <h3 class="card-text"><span class="blue">{{$gift->price}} €</span></h3>
                    @endif
                    <p class="card-text">{{$gift->description}}</p>
                    <form action="{{route('commentaires.create')}}" method="GET">
                        @csrf
                        <input type="hidden" value="{{$gift->id}}" name="gift_id">
                        <button type="submit" class="btn btnBlue mb-2">En discuter...<i class="far fa-comments ps-2"></i></button>
                    </form>
                </div>
                <div class="card-footer">
                    <p class="text-muted small mb-0"><img class="mr-3 rounded-circle me-1" src="{{$gift->user_image}}" alt="Generic placeholder image" style="max-width:30px">{{$gift->user_nickname}} <span class="red"><i class="far fa-calendar-alt ps-3 pe-1"></i></span>{{ \Carbon\Carbon::parse($gift->created_at)->translatedFormat('d F Y à H\hi') }}</p>
                    <!--@if($gift->posted_by_user_id == auth()->id())
                    <div class="row">
                        <div class="col-6">
                            <form action="{{route('accueil.edit', $gift->id)}}" method="GET">
                                @csrf
                                <input type="hidden" name="for_user_id" value="{{$for_user_id}}">
                                <input type="hidden" name="id" value="{{$gift->id}}">
                                <button type="submit" class="btn btnEditSmall px-2 py-0">Modifier</button>
                            </form>
                        </div>
                        <div class="col-6">
                            <form action="{{route('accueil.destroy', $gift->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btnDeleteSmall px-2 py-0">Supprimer</button>
                            </form>
                        </div>
                    </div>
                    @endif-->
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection