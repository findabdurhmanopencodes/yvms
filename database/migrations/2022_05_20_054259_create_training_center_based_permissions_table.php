<?php

use App\Models\CindicationRoom;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_center_based_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TrainingSession::class);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(TraininingCenter::class);
            $table->foreignIdFor(CindicationRoom::class)->nullable();
            $table->foreignIdFor(Permission::class);
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
        Schema::dropIfExists('training_center_based_permissions');
    }
};
