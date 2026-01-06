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
        Schema::create('jp_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('jp_profiles')->cascadeOnDelete();
            $table->text('educational_background');
            $table->text('license_requirement');
            $table->text('work_experience');
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
        Schema::dropIfExists('jp_specifications');
    }
};
