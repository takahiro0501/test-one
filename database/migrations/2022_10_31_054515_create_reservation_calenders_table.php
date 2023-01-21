<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationCalendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_calenders', function (Blueprint $table) {
            $table->id();
            $table->datetime('reservation_datetime')->nullable(false);
            $table->unsignedBigInteger('staff_id')->nullable(false);
            $table->unsignedBigInteger('reservation_id')->nullable(false);
            $table->datetime('created_at')->useCurrent()->nullable();
            $table->datetime('updated_at')->useCurrent()->nullable();

            $table->foreign('staff_id')->references('id')->on('staff');
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_calenders');
    }
}
