<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('a_abouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_structure_id')->constrained('org_structures')->cascadeOnDelete();
            $table->date('birthdate')->nullable();
            $table->string('marital_status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_abouts');
    }
};
