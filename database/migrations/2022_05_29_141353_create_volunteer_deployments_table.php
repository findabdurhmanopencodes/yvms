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
        Schema::create('volunteer_deployments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_placement_id')->constrained('training_placements','id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('woreda_intake_id')->constrained('woreda_intakes','id')->cascadeOnDelete()->cascadeOnUpdate();
//            $table->foreignId('training_session_id')->constrained('training_sessions','id');
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
        Schema::dropIfExists('volunteer_deployments');
    }
};
