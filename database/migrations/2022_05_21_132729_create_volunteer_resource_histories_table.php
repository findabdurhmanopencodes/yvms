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
        Schema::create('volunteer_resource_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->nullable()->constrained('volunteers','id')->nullOnDelete();
            $table->foreignId('resource_id')->nullable()->constrained('resources','id')->nullOnDelete();
            $table->bigInteger('training_session_id');
            $table->bigInteger('training_center_id');
            $table->bigInteger('amount');
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
        Schema::dropIfExists('volunteer_resource_histories');
    }
};
