@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="center-align">Cadastro</h2>

    <form method="POST" action="{{ route('user.store') }}">
        @csrf
        <div class="input-field">
            <input type="text" name="name" id="name" required>
            <label for="name">Nome</label>
            @error('name')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>
        <div class="input-field">
            <input type="email" name="email" id="email" required>
            <label for="email">E-mail</label>
            @error('email')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>
        <div class="input-field">
            <input type="password" name="password" id="password" required>
            <label for="password">Senha</label>
            @error('password')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>
        <div class="input-field">
            <input type="password" name="password_confirmation" id="password_confirmation" required>
            <label for="password_confirmation">Confirmar Senha</label>
            @error('password_confirmation')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>
        <div class="center-align">
            <button type="submit" class="waves-effect waves-light btn">Cadastrar</button>
        </div>
    </form>

    <div class="center-align">
        <p>Já tem uma conta? <a href="{{ route('user.login') }}">Faça login</a></p>
    </div>
</div>
@endsection
