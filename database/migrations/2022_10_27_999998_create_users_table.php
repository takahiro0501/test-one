<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->nullable(false);
            $table->string('line_user_id')->unique()->nullable();
            $table->string('karte_no',50)->unique()->nullable();
            $table->string('name',50)->nullable(false);
            $table->string('name_kana',50)->nullable();
            $table->integer('gender')->nullable(); //(0:男性 1:女性 2:未選択)
            $table->date('first_day')->nullable(); //初診日
            $table->date('birthday')->nullable();
            $table->string('postcode',8)->nullable();
            $table->string('prefecture',5)->nullable();
            $table->string('city',10)->nullable();
            $table->string('address',200)->nullable();
            $table->string('phone',15)->nullable();
            $table->string('cellphone',15)->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->datetime('created_at')->useCurrent()->nullable();
            $table->datetime('updated_at')->useCurrent()->nullable();

            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
