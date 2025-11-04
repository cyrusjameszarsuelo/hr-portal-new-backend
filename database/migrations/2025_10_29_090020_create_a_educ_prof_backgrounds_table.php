<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('a_educ_prof_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('a_about_id')->constrained('a_abouts')->cascadeOnDelete();
            $table->enum('education_level', [
                'primary',
                'secondary',
                'tertiary',
                'vocational',
                'undergraduate',
                'bachelors',
                'masters',
                'doctorate'
            ])->nullable();
            $table->string('school')->nullable();
            $table->string('course')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('honors')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('a_educ_prof_backgrounds');
    }
};
