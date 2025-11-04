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
        Schema::create('jp_performance_standards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_profile_id')->constrained('jp_profiles')->cascadeOnDelete();
            $table->string('name');
            $table->text('values');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::dropIfExists('jp_performance_standards');
    }
};
