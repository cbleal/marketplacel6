<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            # REFERÊNCIA AO CAMPO ID DE USER
            $table->unsignedBigInteger('user_id'); 

            $table->string('name');
            $table->string('description');
            $table->string('phone');
            $table->string('mobile_phone');
            $table->string('slug');

            $table->timestamps();

            # ADD CHAVE ESTRANGEIRA: stores_user_id_foreign
            $table->foreign('user_id')->references('id')->on('users'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_store');
    }
}
