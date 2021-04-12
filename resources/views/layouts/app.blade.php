<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style>
        html,body {height: 100%}
        label {margin-bottom: 0}
    </style>

    <title>@yield('title') | Articles</title>
</head>

<body>

<div class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a href="{{ route('articles.index') }}" class="navbar-brand">Articles</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-navbar"
                aria-controls="bs-navbar" aria-expanded="false" aria-label="">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="bs-navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
            <ul class="nav navbar-nav ml-auto">
                <li class="{{ set_active('articles') }}">
                    <a class="nav-link" href="{{ route('articles.index') }}">Articles</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="container mb-5 mt-3">
    @include('partials.session_messages')
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

</body>
</html>