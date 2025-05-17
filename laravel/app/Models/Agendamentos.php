<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamentos extends Model
{
    use HasFactory;

    protected $table = 'agendamentos';

    protected $primaryKey = 'id';

    protected $fillable = [
        'data_agendamento',      
        'cliente_id',            
        'tipo_reuniao_id',      
        'status_id',  
        'usuario_inclusao_id',          
        'ativo'               
    ];

    protected $casts = [
        'data_agendamento' => 'datetime',
        'ativo' => 'boolean',
    ];

    /**
     * Relacionamento com Cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Relacionamento com Tipo de Reunião
     */
    public function tipoReuniao()
    {
        return $this->belongsTo(TipoReuniao::class, 'tipo_reuniao_id');
    }

    /**
     * Relacionamento com Status de Agendamento
     */
    public function statusAgendamento()
    {
        return $this->belongsTo(StatusAgendamentos::class, 'status_id');
    }

    /**
     * Relacionamento com Atendente (usuário que incluiu o agendamento)
     */
    public function atendente()
    {
        return $this->belongsTo(User::class, 'usuario_inclusao_id');
    }
}
