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
            $table->unsignedBigInteger('UserID');
            $table->integer('bookID');
            $table->dateTime('date');
            $table->unsignedBigInteger('reviewID');

            $table->foreign('reviewID')->references('reviewID')->on('bookReports');
            $table->foreign('UserID')->references('UserID')->on('users');
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
