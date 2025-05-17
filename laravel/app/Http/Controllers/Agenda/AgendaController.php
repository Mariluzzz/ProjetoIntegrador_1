<?php

namespace App\Http\Controllers\Agenda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agendamentos;
use App\Models\TipoReuniao;
use App\Models\StatusAgendamentos;
use App\Models\User;
use App\Models\Cliente;

class AgendaController extends Controller
{
    public function index()
    {
        $tipos = TipoReuniao::all();
        $status = StatusAgendamentos::all();
        $responsaveis = User::all();
        $clientes = Cliente::select('id', 'nome', 'telefone', 'email')->get();

        return view('agenda.screen.index', compact('tipos', 'status', 'responsaveis', 'clientes'));
    }

    public function eventos()
    {
        $eventos = Agendamentos::all()->map(function($e) {
            return [
                'id'    => $e->id,
                'title' => 'Reunião com cliente ID ' . $e->cliente_id,
                'start' => $e->data_agendamento->format('Y-m-d\TH:i:s'),
                'end'   => $e->data_agendamento->addHour()->format('Y-m-d\TH:i:s'),
                'extendedProps' => [
                    'tipo_id'        => $e->tipo_reuniao_id,
                    'status_id'      => $e->status_agendamento_id,
                    'responsavel_id' => $e->atendente_id,
                    'cliente_id'     => $e->cliente_id,
                    'ativo'          => $e->ativo,
                ],
            ];
        });

        return response()->json($eventos);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo' => 'required|integer',
            'status' => 'required|integer',
            'inicio' => 'required|date',
            'responsavel' => 'required|integer',
            'cliente' => 'required|integer',
        ]);

        Agendamentos::create([
            'data_agendamento' => $data['inicio'],
            'cliente_id' => $data['cliente'],
            'tipo_reuniao_id' => $data['tipo'],
            'status_id' => $data['status'],
            'usuario_inclusao_id' => $data['responsavel'],
            'ativo' => true,
        ]);

        return redirect()->route('agenda.index')->with('success', 'Evento criado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'tipo'    => 'required|integer',
            'status'  => 'required|integer',
            'inicio'  => 'required|date',
            'responsavel' => 'required|integer',
            'cliente' => 'required|integer',
        ]);
        
        $evento = Agendamentos::findOrFail($id);
        
        $evento->update([
            'tipo_reuniao_id'        => $data['tipo'],
            'status_agendamento_id'  => $data['status'],
            'data_agendamento'       => $data['inicio'],
            'atendente_id'           => $data['responsavel'],
            'cliente_id'             => $data['cliente'],
            'ativo'                  => true,
        ]);

        return redirect()->route('agenda.index')->with('success', 'Evento atualizado com sucesso!');
    }
}
