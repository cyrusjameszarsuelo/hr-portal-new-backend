<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('a_prev_work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_id')->constrained('a_abouts')->cascadeOnDelete();
            $table->string('company')->nullable();
            $table->string('megawide_equivalent')->nullable();
            $table->string('job_title');
            $table->string('job_level')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('a_prev_work_experiences');
    }
};
