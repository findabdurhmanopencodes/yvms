<?php

use App\Models\File;
use App\Models\Status;
use App\Models\User;
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
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('father_name');
            $table->string('grand_father_name');
            $table->string('email');
            $table->date('dob');
            $table->string('gender');
            $table->string('phone');
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->float('gpa');
            $table->string('password');
            $table->integer('graduation_date')->nullable();
            $table->foreignIdFor(File::class,'photo')->nullable();
            $table->foreignIdFor(File::class,'bsc_document')->nullable();
            $table->foreignIdFor(File::class,'msc_document')->nullable();
            $table->foreignIdFor(File::class,'phd_document')->nullable();
            $table->foreignIdFor(File::class,'ministry_document')->nullable();
            $table->foreignIdFor(File::class,'non_pregnant_validation_document')->nullable();
            $table->foreignIdFor(File::class,'ethical_license')->nullable();
            $table->foreignIdFor(File::class,'kebele_id')->nullable();
            $table->smallInteger('educational_level')->default(0);
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('training_session_id')->nullable()->constrained('training_sessions','id')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('field_of_study_id')->nullable()->constrained('feild_of_studies')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('woreda_id')->nullable()->constrained('woredas')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('disablity_id')->nullable()->constrained('disablities')->nullOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('volunteers');
    }
};
