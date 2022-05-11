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
        Schema::table('training_placements', function (Blueprint $table) {
            $table->foreignId('training_center_capacity_id')->contstrained('training_center_capacities', 'id');
            $table->foreignId('approved_applicant_id')->contstrained('approved_applicants', 'id');
            $table->foreignId('training_session_id')->contstrained('training_sessions', 'id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('training_placements', function (Blueprint $table) {
            //
        });
    }
};
