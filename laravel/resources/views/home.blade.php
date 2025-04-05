@extends('layouts.app')

@section('content')

<div class="container">

    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                M.toast({html: "{{ session('success') }}", classes: 'rounded green'});
            });
        </script>
    @endif

    @auth
        <h2>Bem-vindo a sua Agenda, {{ auth()->user()->name }}!</h1>
    @else
        <h2>Bem-vindo a sua Agenda.</h1>
    @endauth
    
    @guest
        <div class="center-align">
            <p>Faça login para continuar a experiência.</p>
            <a href="{{ route('user.login')}}" class="waves-effect waves-light btn">Login</a>
        </div>
    @endguest
    
    @auth
        <div class="center-align">
            <p>Agora você está logado! Aproveite nossos serviços de gerenciamento :)</p>
        </div>
    @endauth
</div>
@endsection
