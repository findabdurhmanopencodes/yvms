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
        Schema::create('training_sessions', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('moto')->nullable();
            $table->date('registration_start_date');
            $table->date('registration_dead_line');
            $table->date('training_start_date')->nullable();
            $table->date('training_end_date')->nullable();
            $table->integer('quantity');
            $table->tinyInteger('status');
            $table->string('end_date_am')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_sessions');
    }
};
