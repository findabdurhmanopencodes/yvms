<?php

use App\Models\File;
use App\Models\Training;
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
        Schema::create('training_documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(File::class);
            $table->foreignIdFor(Training::class);
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
        Schema::dropIfExists('training_documents');
    }
};
