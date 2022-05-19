<?php

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
            $table->foreignIdFor(TrainingSession::class);
            $table->foreignIdFor(TrainingMaster::class);
            $table->foreignIdFor(TraininingCenter::class);
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
