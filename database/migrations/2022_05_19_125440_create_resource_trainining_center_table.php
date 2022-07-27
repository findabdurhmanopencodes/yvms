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
        Schema::create('resource_trainining', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainining_center_id')->nullable()->constrained('trainining_centers','id')->nullOnDelete();
            $table->foreignId('training_session_id')->nullable()->constrained('training_sessions','id')->nullOnDelete();
            $table->foreignId('resource_id')->nullable()->constrained('resources','id')->nullOnDelete();
            $table->integer('current_balance');
            $table->integer('initial_balance');
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
        Schema::dropIfExists('resource_trainining');
    }
};
