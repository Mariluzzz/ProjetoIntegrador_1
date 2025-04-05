<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoReuniao extends Model
{
    use HasFactory;

    protected $table = 'tipos_reunioes';

    protected $fillable = ['nome', 'ativo'];

    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'tipo_reuniao_id');
    }
}
