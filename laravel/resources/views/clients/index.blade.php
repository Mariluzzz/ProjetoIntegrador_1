@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="center-align">Lista de Clientes</h2>

    @if ($clientes->isEmpty())
        <div class="center-align">
            <p>Não há clientes cadastrados.</p>
        </div>
    @else
        <table class="striped centered responsive-table">
            <thead class="grey lighten-1 black-text">
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Observação</th>
                    <th>Data de Cadastro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr class="grey lighten-2 black-text">
                        <td>{{ $cliente->nome }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>{{ $cliente->telefone }}</td>
                        <td>{{ $cliente->observacao }}</td>
                        <td>{{ \Carbon\Carbon::parse($cliente->created_at)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('client.edit', $cliente->id) }}" class="btn waves-effect waves-light yellow darken-2">Editar</a>

                            <form action="{{ route('client.destroy', $cliente->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn waves-effect waves-light red">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="center-align">
            {{ $clientes->links('pagination::bootstrap-4') }}
        </div>
    @endif

    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                M.toast({html: "{{ session('success') }}", classes: 'rounded green'});
            });
        </script>
    @endif

    <div class="center-align" style="margin-top: 1em;">
        <a class="btn white-text" href="{{ route('client.create') }}">Cadastrar cliente</a>
        <a class="btn white-text" href="{{ route('home') }}">Voltar para o início</a>
    </div>
</div>
@endsection
