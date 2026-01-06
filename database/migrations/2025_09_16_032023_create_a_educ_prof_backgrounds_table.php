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
        Schema::create('a_educ_prof_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_id')->constrained('a_abouts')->cascadeOnDelete();
            
            // Educational Level (e.g., High School, Undergraduate, Post Graduate, etc.)
            $table->string('education_level')->nullable();
            
            // School/University Attended
            $table->string('school_attended')->nullable();
            
            // Degree/Program/Course
            $table->string('degree_program_course')->nullable();
            
            // Academic Achievements / Extracurricular Distinctions
            $table->text('academic_achievements')->nullable();
            
            // Year Started and Year Ended
            $table->string('year_started')->nullable();
            $table->string('year_ended')->nullable();
            
            // Currently studying flag
            $table->boolean('is_current')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_educ_prof_backgrounds');
    }
};
