<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotoristaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {

        Schema::create('motorista', function (Blueprint $table) {
            $table->increments('id_motorista');
            $table->string('email', 150)->unique();
            $table->string('nome', 300);
            $table->string('contato', 20);
            $table->string('senha', 150);
            $table->string('endereco', 100);
            $table->integer('documento');
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
        Schema::dropIfExists('motorista');
    }
}
