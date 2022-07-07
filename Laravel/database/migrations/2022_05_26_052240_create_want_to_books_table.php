<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wantToBooks', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->integer('bookID');
            $table->dateTime('registered_at');
            $table->integer('finished')->nullable();

            $table->foreign('id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wantToBooks');
    }
};
