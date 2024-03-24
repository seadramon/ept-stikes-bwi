<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_conversions', function (Blueprint $table) {
            $table->id();
            $table->integer('raw_score');
            $table->integer('section1')->nullable();
            $table->integer('section2')->nullable();
            $table->integer('section3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score_conversions');
    }
}
