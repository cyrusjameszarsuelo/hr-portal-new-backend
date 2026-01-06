<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('a_megawide_work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_id')->constrained('a_abouts')->cascadeOnDelete();
            // Current role snapshot (one per About)
            $table->foreignId('position_title_id')->nullable()->constrained('position_titles')->onDelete('set null');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->foreignId('sbu_id')->nullable()->constrained('sbus')->onDelete('set null');
            $table->foreignId('level_id')->nullable()->constrained('levels')->onDelete('set null');
            $table->string('employment_status')->nullable();
            $table->date('current_role_start_date')->nullable();
            $table->date('current_role_end_date')->nullable();
            $table->boolean('is_current')->default(true);
            $table->unique('about_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('a_megawide_work_experiences');
    }
};
