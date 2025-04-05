<?php

namespace App\Http\Controllers\Agenda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoReuniao;

class TypesAgendaController extends Controller
{
    public function index()
    {
        $tipos = TipoReuniao::where('ativo', true)->get();
        return view('agenda.typesAgenda.index', compact('tipos'));
    }

    public function create()
    {
        return view('agenda.typesAgenda.createTypeAgenda');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
        ]);

        TipoReuniao::create([
            'nome' => $request->nome,
            'ativo' => 1,
        ]);

        return redirect()->route('tipos.index')->with('success', 'Tipo de reunião cadastrado com sucesso.');
    }

    public function edit(TipoReuniao $tipo)
    {
        return view('agenda.typesAgenda.updateTypeAgenda', compact('tipo'));
    }

    public function update(Request $request, TipoReuniao $tipo)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
        ]);

        $tipo->update([
            'nome' => $request->nome,
        ]);

        return redirect()->route('tipos.index')->with('success', 'Tipo de reunião atualizado com sucesso.');
    }

    public function show(TipoReuniao $tipo)
    {
        return view('agenda.typesAgenda.index', compact('tipo'));
    }

    public function destroy(TipoReuniao $tipo)
    {
        $tipo->delete();

        return redirect()->route('tipos.index')->with('success', 'Tipo de reunião excluído com sucesso.');
    }
}
