<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('a_prev_work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('a_about_id')->constrained('a_abouts')->cascadeOnDelete();
            $table->string('position');
            $table->string('megawide_position_equivalent')->nullable();
            $table->string('department')->nullable();
            $table->string('company')->nullable();
            $table->string('rank')->nullable();
            $table->text('functions_jd')->nullable();
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
