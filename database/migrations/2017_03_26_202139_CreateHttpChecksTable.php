<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHttpChecksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('http_checks', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('url');
            $table->string('name');
            $table->integer('every')->default(1)->unsigned();
            $table->integer('offset')->default(0)->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('http_checks');
    }
}
