<?php

use App\Models\TrainingSession;
use App\Models\TraininingCenter;
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
        Schema::create('cindication_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TrainingSession::class)->constrained();
            $table->foreignIdFor(TraininingCenter::class)->constrained();
            $table->smallInteger('number_of_volunteers');
            $table->string('number');
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
        Schema::dropIfExists('cindication_rooms');
    }
};
