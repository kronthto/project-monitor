<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFailureHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('failure_history', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->text('message')->nullable();
            $table->timestamp('date');
            $table->integer('check_id')->unsigned();
            $table->string('check_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('failure_history');
    }
}
