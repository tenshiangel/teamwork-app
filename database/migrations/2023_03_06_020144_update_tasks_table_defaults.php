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
        Schema::table('tasks', function (Blueprint $table) {
            $table->enum('status', ['to-do', 'ongoing', 'closed', 'removed'])->default('to-do')->change();
            $table->tinyInteger('completion')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->enum('status', ['to-do', 'ongoing', 'closed', 'removed'])->change();
            $table->tinyInteger('completion')->change();
        });
    }
};
