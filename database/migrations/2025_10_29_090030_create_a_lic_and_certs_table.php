<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('a_lic_and_certs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('a_educ_prof_background_id')->constrained('a_educ_prof_backgrounds')->cascadeOnDelete();
            $table->string('lic_and_cert');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('a_lic_and_certs');
    }
};
