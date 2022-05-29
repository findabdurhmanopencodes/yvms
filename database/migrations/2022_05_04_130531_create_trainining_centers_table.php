<?php

use App\Models\File;
use App\Models\Zone;
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
        Schema::create('trainining_centers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(File::class,'logo')->nullable()->constrained('files','id');
            $table->string('name');
            $table->string('decription')->nullable();
            $table->string('code')->nullable();
            $table->foreignIdFor(Zone::class)->constrained();
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
        Schema::dropIfExists('trainining_centers');
    }
};
