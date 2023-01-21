<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultipleClosedDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multiple_closed_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id')->nullable(false);
            $table->integer('week_no')->nullable(false);
            $table->tinyInteger('status')->nullable(false); //0:営業曜日 、1：休日曜日
            $table->datetime('created_at')->useCurrent()->nullable();
            $table->datetime('updated_at')->useCurrent()->nullable();

            $table->foreign('staff_id')->references('id')->on('staff');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('multiple_closed_days');
    }
}
