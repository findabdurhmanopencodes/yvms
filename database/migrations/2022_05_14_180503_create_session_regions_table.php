<?php

use App\Models\Region;
use App\Models\TrainingSession;
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
        Schema::create('session_regions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Region::class)->constrained();
            $table->foreignIdFor(TrainingSession::class)->constrained();
            $table->double('qoutaInpercent')->nullable();
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
        Schema::dropIfExists('session_regions');
    }
};
