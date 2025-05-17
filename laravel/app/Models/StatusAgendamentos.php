<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusAgendamentos extends Model
{
    use HasFactory;

    protected $table = 'status_agendamentos';

    protected $fillable = [
        'nome',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    /**
     * Relacionamento com agendamentos que usam este status
     */
    public function agendamentos()
    {
        return $this->hasMany(Agendamentos::class, 'status_agendamento_id');
    }
}
