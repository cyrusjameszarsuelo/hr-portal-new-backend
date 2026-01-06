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
        Schema::create('jp_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_structure_id')->nullable()->constrained()->nullOnDelete();
            $table->unique('org_structure_id');
            $table->text('job_purpose');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jp_profiles');
    }
};
