@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="center-align">Status de Reunião</h2>

    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                M.toast({html: "{{ session('success') }}", classes: 'rounded green'});
            });
        </script>
    @endif

    <div class="right-align">
        <a href="{{ route('status.create') }}" class="btn">Cadastrar Tipo</a>
    </div>

    @if ($status->isEmpty())
    <p class="center-align">Nenhum status cadastrado ainda.</p>
    @else
    <table class="striped responsive-table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($status as $statu)
                <tr>
                    <td>{{ $statu->nome }}</td>
                    <td>
                        <a href="{{ route('status.edit', $statu->id) }}" class="btn yellow darken-2">Editar</a>
                        <form action="{{ route('status.destroy', $statu->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn red">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
