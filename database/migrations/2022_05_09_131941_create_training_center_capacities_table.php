<?php

use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use Database\Seeders\TrainingSessionSeeder;
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
        Schema::create('training_center_capacities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TraininingCenter::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(TrainingSession::class)->constrained()->onDelete('cascade');
            $table->integer('capacity');
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
        Schema::dropIfExists('training_center_capacities');
    }
};
