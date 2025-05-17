@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="center-align">Editar Status</h2>

    <form method="POST" action="{{ route('status.update', $status->id) }}">
        @csrf
        @method('PUT')

        <div class="input-field">
            <input type="text" name="nome" id="nome" value="{{ old('nome', $status->nome) }}">
            <label for="nome" class="active">Nome</label>
            @error('nome')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="center-align">
            <button type="submit" class="btn">Atualizar</button>
        </div>
    </form>

    <div class="center-align" style="margin-top: 1em;">
        <a class="btn" href="{{ route('status.index') }}">Voltar</a>
    </div>
</div>
@endsection
