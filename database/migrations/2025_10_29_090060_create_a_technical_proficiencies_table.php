<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('a_technical_proficiencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_id')->constrained('a_abouts')->cascadeOnDelete();
            $table->string('skills');
            $table->string('proficiency')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('a_technical_proficiencies');
    }
};
