<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name',50)->nullable(false);
            $table->string('overview',500)->nullable(false);
            $table->integer('time')->nullable(false);
            $table->integer('money')->nullable(false);
            $table->integer('time_separator')->nullable(false);
            $table->integer('priority')->nullable(false);
            $table->tinyInteger('delete_flg')->nullable(false);
            $table->datetime('created_at')->useCurrent()->nullable();
            $table->datetime('updated_at')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
