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
        Schema::create('finishedBooks', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->integer('bookID');
            $table->dateTime('date');
            $table->unsignedBigInteger('reviewID');
            $table->integer('delete')->nullable();

            $table->foreign('reviewID')->references('reviewID')->on('bookReports');
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
        Schema::dropIfExists('finishedBooks');
    }
};
