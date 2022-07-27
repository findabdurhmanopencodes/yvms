<?php

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
        // Schema::create('bar_q_r_volunteers', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignIdFor(Volunteer::class)->constrained();
        //     $table->longText('bar_code');
        //     $table->longText('qr_code');
        //     $table->integer('created_at');
        //     $table->integer('updated_at');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bar_q_r_volunteers');
    }
};
