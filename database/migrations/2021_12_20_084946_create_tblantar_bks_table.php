<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblantarBksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblantar_bks', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->timestamps();
            $table->foreignId('user_id');
            $table->string('tbljemput_id')->unique()->nullable(false);
            $table->foreignId('status_id');
            $table->bigInteger('talangan');
            $table->integer('ongkir');
            $table->string('catatan')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblantar_bks');
    }
}
