<?php

use App\Models\CindicationRoom;
use App\Models\Training;
use App\Models\TrainingMaster;
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
        Schema::create('training_master_placements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TrainingSession::class)->constrained();
            $table->foreignIdFor(TrainingMaster::class)->constrained();
            $table->foreignIdFor(TraininingCenter::class)->constrained();
            $table->foreignIdFor(CindicationRoom::class)->constrained();
            $table->foreignIdFor(Training::class)->constrained();
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
        Schema::dropIfExists('training_master_placements');
    }
};
