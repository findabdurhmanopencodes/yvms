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
        Schema::create('approved_applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TrainingSession::class)->onDelete('cascade');
            $table->foreignIdFor(Volunteer::class)->onDelete('cascade');
            $table->smallInteger('status');
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
        Schema::dropIfExists('approved_applicants');
    }
};
