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
        Schema::create('jp_level_of_authorities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_profile_id')->constrained('jp_profiles')->cascadeOnDelete();
            $table->text('line_authority')->nullable();
            $table->text('staff_authority')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::dropIfExists('jp_level_of_authorities');
    }
};
