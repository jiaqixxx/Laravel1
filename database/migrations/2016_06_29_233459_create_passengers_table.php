<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('Given_Name');
            $table->string('Surname');
            $table->string('Email');
            $table->integer('Mobile');
            $table->string('Passport');
            $table->date('Date_of_Birth');
            $table->mediumText('Special_Request');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('passengers');
    }
}