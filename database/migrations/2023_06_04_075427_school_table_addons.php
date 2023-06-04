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
        Schema::table('schools', function($table) {
            $table->integer('type');
            $table->integer('school_data_id');
            $table->string('coordinates');
            $table->string('registration_number');
            $table->string('phone_number');
            $table->string('email');
            $table->string('url');
            $table->string('image');
            $table->string('manager');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function($table) {
            $table->dropColumn('type');
            $table->dropColumn('school_data_id');
            $table->dropColumn('coordinates');
            $table->dropColumn('registration_number');
            $table->dropColumn('phone_number');
            $table->dropColumn('email');
            $table->dropColumn('url');
            $table->dropColumn('image');
            $table->dropColumn('manager');
        });
    }
};
