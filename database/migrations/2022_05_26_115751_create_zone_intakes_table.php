<?php

use App\Models\TrainingSession;
use App\Models\Zone;
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
        Schema::create('zone_intakes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TrainingSession::class)->constrained();
            $table->foreignIdFor(Zone::class)->constrained();
            $table->integer('intake');
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
        Schema::dropIfExists('zone_intakes');
    }
};
