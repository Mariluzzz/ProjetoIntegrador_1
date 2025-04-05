@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="center-align">{{ isset($cliente) ? 'Editar' : 'Cadastrar' }} Cliente</h2>

    <form method="POST" action="{{ isset($cliente) ? route('client.update', $cliente->id) : route('client.store') }}">
        @csrf
        @isset($cliente)
            @method('PUT')
        @endisset

        <div class="input-field">
            <input type="text" name="nome" id="nome" value="{{ old('nome', $cliente->nome ?? '') }}">
            <label for="nome">Nome</label>
            @error('nome')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-field">
            <input type="email" name="email" id="email" value="{{ old('email', $cliente->email ?? '') }}">
            <label for="email">E-mail</label>
            @error('email')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-field">
            <input type="text" name="telefone" id="telefone" value="{{ old('telefone', $cliente->telefone ?? '') }}">
            <label for="telefone">Telefone</label>
            @error('telefone')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-field">
            <textarea name="observacao" id="observacao" class="materialize-textarea" maxlength="150">{{ old('observacao', $cliente->observacao ?? '') }}</textarea>
            <label for="observacao">Observação</label>
            @error('observacao')
                <span class="helper-text red-text">{{ $message }}</span>
            @enderror
        </div>

        {{-- Hidden field de "ativo" --}}
        <input type="hidden" name="ativo" value="1">

        <div class="center-align">
            <button type="submit" class="waves-effect waves-light btn">
                {{ isset($cliente) ? 'Atualizar' : 'Cadastrar' }}
            </button>
        </div>
    </form>

    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                M.toast({html: "{{ session('success') }}", classes: 'rounded green'});
            });
        </script>
    @endif

    <div class="center-align" style="margin-top: 1em;">
        <a class="btn white-text" href="{{ route('client.index') }}">Voltar à lista de clientes</a>
    </div>
</div>
@endsection
