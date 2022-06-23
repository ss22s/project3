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
        Schema::create('bookReports', function (Blueprint $table) {
            $table->id('reviewID');
            $table->unsignedBigInteger('UserID');
            $table->integer('bookID');
            $table->integer('evaluation');
            $table->integer('selectedComment');
            $table->string('comment',10000);
            $table->integer('Open');
            $table->dateTime('created_at');

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
        Schema::dropIfExists('bookReports');
    }
};