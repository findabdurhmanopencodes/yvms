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
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('father_name');
            $table->string('grand_father_name');
            $table->string('email')->unique();
            $table->date('dob');
            $table->string('gender');
            $table->string('phone');
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->float('gpa');
            $table->string('photo')->nullable();
            $table->string('bsc_document');
            $table->string('msc_document')->nullable();
            $table->string('ministry_document');
            $table->string('non_pregnant_validation_document')->nullable();
            $table->string('ethical_license')->nullable();
            $table->string('kebele_id');
            $table->foreignId('educational_level_id')->nullable()->constrained('educational_levels','id')->nullOnDelete()->cascadeOnUpdate();
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
