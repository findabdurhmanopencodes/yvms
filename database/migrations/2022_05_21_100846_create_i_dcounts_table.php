<?php

use App\Models\TrainingSession;
use App\Models\Volunteer;
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
        Schema::create('i_dcounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Volunteer::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(TrainingSession::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('count');
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
        Schema::dropIfExists('i_dcounts');
    }
};
