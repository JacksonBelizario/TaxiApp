<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViagemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viagem', function (Blueprint $table) {
            $table->increments('id_viagem');
            $table->unsignedInteger('id_cliente');
            $table->foreign('id_cliente')->references('id_cliente')->on('cliente');
            $table->unsignedInteger('id_motorista');
            $table->foreign('id_motorista')->references('id_motorista')->on('motorista')->nullable();
            $table->string('status', 10);
            $table->timestamp('duracao')->nullable();
            $table->float('distancia', 5, 2);
            $table->string('forma_pagamento', 5)->nullable();
            $table->float('valor', 10, 2)->nullable();
            $table->string('origem', 150);
            $table->string('destino', 150);
            $table->timestamp('data_hora');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('viagem');
    }
}
