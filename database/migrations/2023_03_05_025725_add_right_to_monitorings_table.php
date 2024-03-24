<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRightToMonitoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monitorings', function (Blueprint $table) {
            $table->integer('section_1_qty')->default('0');
            $table->integer('section_2_qty')->default('0');
            $table->integer('section_3_qty')->default('0');

            $table->integer('section_1_right')->default('0');
            $table->integer('section_2_right')->default('0');
            $table->integer('section_3_right')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monitorings', function (Blueprint $table) {
            $table->dropColumn('section_1_qty');
            $table->dropColumn('section_2_qty');
            $table->dropColumn('section_3_qty');

            $table->dropColumn('section_1_right');
            $table->dropColumn('section_2_right');
            $table->dropColumn('section_3_right');
        });
    }
}
