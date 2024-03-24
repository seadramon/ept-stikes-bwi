<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('part_id');
            $table->foreign('part_id')->references('id')->on('parts');

            $table->text('story')->nullable();
            $table->text('question')->nullable();

            $table->text('choice_a')->nullable();
            $table->text('choice_b')->nullable();
            $table->text('choice_c')->nullable();
            $table->text('choice_d')->nullable();

            $table->string('answer', 1)->nullable();
            $table->string('filename')->nullable();
            $table->integer('urutan');

            $table->softDeletes();
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
        Schema::dropIfExists('questions');
    }
}
