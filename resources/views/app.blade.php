<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secret Gift List - @yield('title')</title>
    <meta name="description" content="@yield('description')">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- STYLE -->
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }} ">

    <!-- ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css">


</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <!-- <a class="navbar-brand mr-auto" href="{{route('accueil.index')}}">SGL</a> -->
        <button class="navbar-toggler custom-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            @guest
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('login')}}">Se connecter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('registration')}}">S'enregistrer</a>
                </li>
            </ul>
            @else
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('accueil.index')}}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('mon-profil.index')}}">Mon profil</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <span class="navbar-text">
                    Bonjour {{Auth::user()->nickname}},
                </span>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('signout')}}">se déconnecter</a>
                </li>
            </ul>
            @endguest
        </div>
    </div>
</nav>

<div class="container-fluid mt-5 mb-5 headPage text-center">
    <!-- <div class="row">
        <h1 class="text-center">SECRET <span class="blue">GIFT</span> LIST</h1>
    </div> -->
    <img src="/images/logo.png" alt="Logo">
</div>

<div class="container mt-5 mb-0">
    <div class="row">
        <div class="col-4 offset-4 text-center">
            @if(session()->get("success"))
                <div class="alert alert-success">
                    {{ session()->get("success") }}
                </div><br />
            @endif
        </div>
    </div>
</div>

<div class="container mt-5 mb-0">
    <div class="row">
        <div class="col-4 offset-4 text-center">
            @if(session()->get("alert"))
                <div class="alert alert-danger">
                    {{ session()->get("alert") }}
                </div><br />
            @endif
        </div>
    </div>
</div>

<div class="container">
    @yield("content")
</div>


<footer>
    <div class="container mt-5 mb-5">
        <div class="row">
            <p class="text-center">© YWebDev 2021.</p>

        </div>
    </div>
</footer>

    <!-- BOOTSTRAP -->   
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
</body>
</html>