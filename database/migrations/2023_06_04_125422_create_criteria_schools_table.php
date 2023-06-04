<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('criteria_schools', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('criteria_id')->unsigned();
            $table->unsignedBiginteger('school_id')->unsigned();
            $table->foreign('school_id')->references('id')
                ->on('schools')->onDelete('cascade');
            $table->foreign('criteria_id')->references('id')
                ->on('criterias')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteria_schools');
    }
};
