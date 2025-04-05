<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cliente;

class ClientController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with('tipoReuniao')->paginate(10);
        return view('clients.index', compact('clientes'));
    }

    public function create()
    {
        return view('clients.createClient');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email',
            'telefone' => 'required|string|max:20',
            'observacao' => 'nullable|string|max:150',
        ]);

        Cliente::create($request->all());

        return redirect()->route('client.index')->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clients.updateClient', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'telefone' => 'required|string|max:20',
            'observacao' => 'nullable|string|max:150',
        ]);

        $cliente->update($request->all());

        return redirect()->route('client.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente excluído com sucesso!');
    }
}
