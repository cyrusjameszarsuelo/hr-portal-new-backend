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
        Schema::create('jp_descriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('jp_profiles')->cascadeOnDelete();
            $table->foreignId('subfunction_position_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kra_id')->constrained()->cascadeOnDelete();
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jp_descriptions');
    }
};
