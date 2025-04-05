<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('data_agendamento');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('status_id')->constrained('status_agendamentos');
            $table->foreignId('usuario_inclusao_id')->constrained('users');
            $table->foreignId('tipo_reuniao_id')->constrained('tipos_reunioes');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendamentos');
    }
};
