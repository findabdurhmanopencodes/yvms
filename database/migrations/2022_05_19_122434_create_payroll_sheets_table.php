<?php

use App\Models\Payroll;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\Zone;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
  {
            Schema::create('payroll_sheets', function (Blueprint $table) {
            $table->id();
           // $table->string('payrollId');
            $table->foreignIdFor(Payroll::class)->constrained();
            $table->text('fullName')->nullable();
            $table->foreignIdFor(TraininingCenter::class)->constrained();
            $table->text('phone')->nullable();
            $table->decimal('account',10,2)->nullable();
            //$table->float('amount', 10, 2);
            //$table->double('column', 10, 2); 
            $table->foreignIdFor(Zone::class)->constrained();
            $table->foreignIdFor(User::class);
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
        Schema::dropIfExists('payroll_sheets');
    }
};
