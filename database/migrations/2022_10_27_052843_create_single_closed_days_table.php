<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSingleClosedDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('single_closed_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id')->nullable(false);
            $table->date('closed_day')->nullable(false);
            $table->tinyInteger('status')->nullable(false); //0:休日→営業日 , 1:営業日→休日
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
        Schema::dropIfExists('single_closed_days');
    }
}
