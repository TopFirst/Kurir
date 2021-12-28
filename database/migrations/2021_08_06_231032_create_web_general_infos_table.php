<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebGeneralInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_general_infos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama');
            $table->string('hp1');
            $table->string('hp2');
            $table->string('email1');
            $table->string('email2');
            $table->string('alamat1');
            $table->string('alamat2');
            $table->string('url_logo');
            $table->string('fb');
            $table->string('twitter');
            $table->string('ig');
            $table->string('yt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_general_infos');
    }
}
