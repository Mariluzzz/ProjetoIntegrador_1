<?php

namespace App\Http\Controllers\Agenda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatusAgendamentos;

class StatusAgendaController extends Controller
{
    public function index()
    {
        $status = StatusAgendamentos::where('ativo', true)->get();
        return view('agenda.statusAgenda.index', compact('status'));
    }

    public function create()
    {
        return view('agenda.statusAgenda.createStatusAgenda');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
        ]);

        StatusAgendamentos::create([
            'nome' => $request->nome,
            'ativo' => 1,
        ]);

        return redirect()->route('status.index')->with('success', 'Status cadastrado com sucesso.');
    }

    public function edit(StatusAgendamentos $status)
    {
        return view('agenda.statusAgenda.updateStatusAgenda', compact('status'));
    }

    public function update(Request $request, StatusAgendamentos $status)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
        ]);

        $status->update([
            'nome' => $request->nome,
        ]);

        return redirect()->route('status.index')->with('success', 'Status atualizado com sucesso.');
    }

    public function show(StatusAgendamentos $status)
    {
        return view('agenda.statusAgenda.index', compact('status'));
    }

    public function destroy(StatusAgendamentos $status)
    {
        $status->delete();

        return redirect()->route('status.index')->with('success', 'Status excluído com sucesso.');
    }
}
