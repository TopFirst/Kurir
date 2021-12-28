<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_abouts', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('subjudul1');
            $table->string('subjudul2');
            $table->string('url_logo');
            $table->string('desc');
            $table->string('option1');
            $table->string('option2');
            $table->string('option3');
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
        Schema::dropIfExists('web_abouts');
    }
}
