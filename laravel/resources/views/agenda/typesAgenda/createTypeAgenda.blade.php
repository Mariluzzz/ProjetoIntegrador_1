@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="center-align">Cadastrar Tipo de Reunião</h2>

    <form method="POST" action="{{ route('tipos.store') }}">
        @csrf
        <div class="input-field">
            <input type="text" name="nome" id="nome" value="{{ old('nome') }}">
            <label for="nome">Nome</label>
            @error('nome')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="center-align">
            <button type="submit" class="btn">Cadastrar</button>
        </div>
    </form>

    <div class="center-align" style="margin-top: 1em;">
        <a class="btn" href="{{ route('tipos.index') }}">Voltar</a>
    </div>
</div>
@endsection
