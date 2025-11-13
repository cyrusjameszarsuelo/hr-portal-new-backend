<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('a_megawide_work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('a_about_id')->constrained('a_abouts')->cascadeOnDelete();
            // Current role snapshot (one per About)
            $table->string('job_title')->nullable();
            $table->string('department')->nullable();
            $table->string('unit')->nullable();
            $table->string('job_level')->nullable();
            $table->string('employment_status')->nullable();
            $table->date('current_role_start_date')->nullable();
            $table->date('current_role_end_date')->nullable();
            $table->boolean('is_current')->default(true);
            $table->unique('a_about_id');
            // No timestamps as per spec
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('a_megawide_work_experiences');
    }
};
