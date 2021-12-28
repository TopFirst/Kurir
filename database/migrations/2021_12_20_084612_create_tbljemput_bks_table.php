<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbljemputBksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbljemput_bks', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->timestamps();
            $table->foreignId('user_id');
            $table->string('deskripsi');
            $table->string('hp_seller');
            $table->bigInteger('talangan');
            $table->integer('ongkir');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbljemput_bks');
    }
}
