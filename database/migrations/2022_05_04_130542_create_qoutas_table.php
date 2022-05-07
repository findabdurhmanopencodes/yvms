<?php

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
        Schema::create('qoutas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TrainingSession::class)->onDelete('cascade');
            $table->integer('quotable_id');
            $table->string('quotable_type');
            $table->integer('quantity');
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
        Schema::dropIfExists('qoutas');
    }
};
