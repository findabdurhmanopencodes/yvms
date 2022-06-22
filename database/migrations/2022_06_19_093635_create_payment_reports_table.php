<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\PaymentType;
use App\Models\TraininingCenter;
use App\Models\TrainingSession;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_reports', function (Blueprint $table) {
             $table->id();
             $table->foreignIdFor(TraininingCenter::class)->constrained();
             $table->foreignIdFor(TrainingSession::class)->constrained();
             $table->foreignIdFor(PaymentType::class)->constrained();
             $table->foreignIdFor(User::class)->constrained();
             $table->decimal('total_amount',10,2)->nullable();
             $table->integer('total_payee')->nullable();
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
        Schema::dropIfExists('payment_reports');
    }
};
