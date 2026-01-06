<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jp_reporting_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('jp_profiles')->cascadeOnDelete();
            $table->string('primary')->nullable();
            $table->string('secondary')->nullable();
            $table->string('tertiary')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jp_reporting_relationships');
    }
};
