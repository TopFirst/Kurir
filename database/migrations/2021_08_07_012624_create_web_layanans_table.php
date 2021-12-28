<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebLayanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_layanans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama')->unique();
            $table->string('sub_judul')->nullable();
            $table->string('tipe');
            $table->string('url_logo')->nullable();
            $table->longText('desc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_layanans');
    }
}
