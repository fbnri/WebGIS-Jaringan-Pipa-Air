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
        Schema::table('pipes', function (Blueprint $table) {
            $table->date('planned_at')->nullable()->after('length');
            $table->date('installed_at')->nullable()->after('planned_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pipes', function (Blueprint $table) {
            $table->dropColumn(['planned_at', 'installed_at']);
        });
    }
};
