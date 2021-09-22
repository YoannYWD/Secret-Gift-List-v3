@extends('app')

@section('title')
Modification {{$gift->name}}
@endsection
@section('description', "Modifiez le cadeaux que vous avez proposé, à l'utilisateur que vous avez choisi. Mettez à jour en fonction de la wishlist de l'utilisateur choisi!")


@section('content')

<!-- BOUTON RETOUR A LA PAGE CREATION DE CADEAU DU BENEFICIAIRE SELECTIONNE -->
<!--<div class="container">
    <div class="row text-center">
        <form action="{{route('accueil.create')}}" method="GET">
        @csrf
            <input type="hidden" name="for_user_id" value="{{$gift->for_user_id}}">
            <button type="submit" class="btn btnGreenBgBlue">Retourner à la liste des cadeaux</button>
        </form>
    </div>
</div>-->


<div class="container editGiftContainer mt-5">
    <div class="row mb-4">

        <!-- FORMULAIRE MODIFICATION CADEAU -->
        <div class="col-md-8 offset-md-2 col-xl-6 offset-xl-3">
            <p class="intro text-center"><span class="yellow">Modifie</span> ton cadeau</p>
            <form action="{{route('accueil.update', $gift->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <!-- nom -->
                <div class="mb-3">
                    <input type="text" placeholder="Nom" class="form-control" name="name" value="{{$gift->name}}" required autofocus>
                    @if($errors->has('name'))
                    <span class="text-danger">{{$errors->first('name')}}</span>
                    @endif
                </div>

                <!-- prix -->
                <div class="mb-3">
                    <input type="number" placeholder="Prix" class="form-control" name="price" value="{{$gift->price}}" required autofocus>
                    @if($errors->has('price'))
                    <span class="text-danger">{{$errors->first('price')}}</span>
                    @endif
                </div>

                <!-- description -->
                    <div class="mb-3">
                    <input type="text" placeholder="Description" class="form-control" name="description" value="{{$gift->description}}" required autofocus>
                    @if($errors->has('description'))
                    <span class="text-danger">{{$errors->first('description')}}</span>
                    @endif
                </div>

                <!-- image -->
                <div class="mb-3">
                    <label for="formFile" class="form-label">Image</label>
                    <input class="form-control" type="file" name="image">
                </div>

                <div class="d-grid mx-auto">
                    <input type="hidden" name="posted_by_user_id" value="{{auth()->id()}}">
                    <input type="hidden" name="for_user_id" value="{{$for_user_id}}">
                    <button type="submit" class="btn btnGreenBgBlue btn-block">Enregistrer</button>
                </div>
            </form>


        </div>
    </div>
</div>


@endsection