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
        Schema::create('MyPages', function (Blueprint $table) {
            $table->unsignedBigInteger('UserID');
            $table->string('favoriteBook');
            $table->string('favoriteAuthor');
            $table->string('freeText');

            $table->primary('UserID');
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
        Schema::dropIfExists('MyPages');
    }
};
