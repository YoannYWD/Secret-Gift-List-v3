@extends('app')

@section('title', 'Enregistrement')

@section('content')

<!-- FORMULAIRE REGISTRATION -->
<main class="login-form">
    <div class="container darkBlue mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <p class="intro text-center"><span class="yellow">Enregistre</span>-toi !</p>
                <form action="{{route('userRegistration')}}" method="POST" enctype="multipart/form-data" class="mb-3">
                    @csrf
                    <!-- nom -->
                    <div class="mb-3">
                        <input type="text" placeholder="Nom" class="form-control" name="lastname">
                        @if($errors->has('lastname'))
                        <span class="red text-danger">{{$errors->first('lastname')}}</span>
                        @endif
                    </div>

                    <!-- prénom -->
                    <div class="mb-3">
                        <input type="text" placeholder="Prénom" class="form-control" name="firstname">
                        @if($errors->has('firstname'))
                        <span class="text-danger">{{$errors->first('firstname')}}</span>
                        @endif
                    </div>

                    <!-- pseudo -->
                    <div class="mb-3">
                        <input type="text" placeholder="Pseudo" class="form-control" name="nickname">
                        @if($errors->has('nickname'))
                        <span class="text-danger">{{$errors->first('nickname')}}</span>
                        @endif
                    </div>

                    <!-- email -->
                    <div class="mb-3">
                        <input type="email" placeholder="Email" class="form-control" name="email">
                        @if($errors->has('email'))
                        <span class="text-danger">{{$errors->first('email')}}</span>
                        @endif
                    </div>

                    <!-- avatar -->
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Photo de profil</label>
                        <input class="form-control" type="file" name="image">
                        @if($errors->has('image'))
                        <span class="text-danger">{{$errors->first('image')}}</span>
                        @endif
                    </div>

                    <!-- mot de passe -->
                    <div class="mb-3">
                        <input type="password" placeholder="Mot de passe" class="form-control" name="password">
                        <p class="extraSmall">Min 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.</p>
                        @if($errors->has('password'))
                        <span class="text-danger">{{$errors->first("password")}}</span>
                        @endif
                    </div>

                    <div class="d-grid mx-auto">
                        <button type="submit" class="btn btnGreenBgBlue btn-block">S'enregistrer</button>
                    </div>
                </form>
                Déjà membre ? <a href="{{route('login')}}"><span class="yellow">Connecte</span>-toi</a>.
            </div>
        </div>
    </div>
</main>

@endsection