<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('a_lic_and_certs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('a_about_id')->constrained('a_abouts')->cascadeOnDelete();
            
            // License/Certification/Special Course Details
            $table->string('license_certification_name')->nullable();
            $table->string('issuing_organization')->nullable();
            $table->string('license_certification_number')->nullable();
            $table->date('date_issued')->nullable();
            $table->date('date_of_expiration')->nullable();
            $table->boolean('non_expiring')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('a_lic_and_certs');
    }
};
