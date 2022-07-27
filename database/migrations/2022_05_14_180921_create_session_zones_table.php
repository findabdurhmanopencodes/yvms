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
        Schema::create('session_zones', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Zone::class)->constrained();
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
        Schema::dropIfExists('session_zones');
    }
};
