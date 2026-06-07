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
        Schema::create('pipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('pipe_type');
            $table->enum('status', ['terpasang'],['perencanaan']);
            $table->integer('year');
            $table->double('length')->nullable();
            $table->longText('geometry');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pipes');
    }
};
