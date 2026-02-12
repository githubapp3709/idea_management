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
        Schema::create('idea_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idea_id')->constrained();
            $table->integer('points');
            $table->integer('bonus_points')->default(0);
            $table->foreignId('awarded_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idea_rewards');
    }
};
