<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitorings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('jadwal_id');

            $table->text('section1_answer')->nullable();
            $table->text('section2_answer')->nullable();
            $table->text('section3_answer')->nullable();

            $table->integer('section_1')->default('0');
            $table->integer('section_2')->default('0');
            $table->integer('section_3')->default('0');
            $table->integer('total')->default('0');

            $table->dateTime('start')->nullable();
            $table->dateTime('finish')->nullable();
            $table->integer('status')->default('0');

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
        Schema::dropIfExists('monitorings');
    }
}
