<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'tipo_reuniao_id',
        'observacao',
        'ativo'
    ];

    public function tipoReuniao()
    {
        return $this->belongsTo(TipoReuniao::class, 'tipo_reuniao_id');
    }
}
