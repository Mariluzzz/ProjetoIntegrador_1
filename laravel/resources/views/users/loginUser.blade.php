@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="center-align">Login</h2>

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                M.toast({html: '{{ $errors->first() }}', classes: 'rounded red'});
            });
        </script>
    @endif

    @if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            M.toast({html: "{{ session('success') }}", classes: 'rounded green'});
        });
    </script>
    @endif

    <form method="POST" action="{{ route('user.validate') }}">
        @csrf
        <div class="input-field">
            <input type="email" name="email" id="email" required>
            <label for="email">E-mail</label>
        </div>
        <div class="input-field">
            <input type="password" name="password" id="password" required>
            <label for="password">Senha</label>
        </div>
        <div class="center-align">
            <button type="submit" class="waves-effect waves-light btn">Login</button>
        </div>
    </form>

    <div class="center-align">
        <p>Não tem uma conta? <a href="{{ route('user.create')}}">Cadastre-se</a></p>
    </div>
</div>
@endsection
