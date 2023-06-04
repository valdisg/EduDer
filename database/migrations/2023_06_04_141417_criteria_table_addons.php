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
        Schema::table('criterias', function($table) {
            $table->string('name');
            $table->string('overname');
            $table->string('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function($table) {
            $table->dropColumn('name');
            $table->dropColumn('overname');
            $table->dropColumn('type');
        });
    }
};
