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
            $table->string('position');
            $table->string('department')->nullable();
            $table->string('rank')->nullable();
            $table->date('start_date')->nullable();
            // No timestamps as per spec
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('a_megawide_work_experiences');
    }
};
