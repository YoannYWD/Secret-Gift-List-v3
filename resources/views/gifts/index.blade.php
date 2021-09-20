@extends('app')

@section('title', 'Accueil')
@section('description', "Découvrez tous les utilisateurs qui souhaitent recevoir le bon cadeau, à chaque occasion. Cadeau d'anniversaire, de noël, de mariage, chaque fête a sa liste secrète.")

@section('content')

<!-- PAGE ACCUEIL AVEC LISTE DES GROUPES VISIBLES -->
<div class="container">
    <div class="row">
        <p class="intro">Te voilà au <span class="red">coeur</span> même du secret ! Ici tu ne verras jamais les <span class="green">cadeaux</span> que ta famille souhaite t'offrir. Du moins, j'ai fait mon maximum pour que la <span class="yellow">surprise</span> reste belle. Mais si tu veux les aiguiller, tu peux aller remplir ta <span class="blue">wishlist</span>, dans ton profil, accessible dans le <span class="green">menu</span> la-haut. Et sous ce petit paragraphe, tu as accès aux <span class="red">groupes</span> de tous les autres membres de ta famille. Vas-y, <span class="yellow">entre</span> !</p>
       
        @foreach($users as $user)

            @if($user->id !== auth()->id())
                <div class="col-md-6 col-xl-4 mt-5 mb-4">
                    <div class="card cardIndex">
                        <div class="card-body text-center ">
                            <h5 class="card-title">Cadeaux pour <span class="blue">{{$user->nickname}}</h5>
                            <img src="{{$user->image}}" alt="Photo de {{$user->nickname}}" class="mb-4 mt-4">
                            <form action="{{route('accueil.create')}}" method="GET">
                                @csrf
                                <input type="hidden" name="for_user_id" value="{{$user->id}}">
                                <button type="submit" class="btn btnDarkBlue"><p class="mb-0">Voir les cadeaux</p></button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

    </div>
</div>


@endsection