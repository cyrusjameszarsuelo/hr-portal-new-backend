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
        Schema::create('job_profile_duties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_profile_kra_id')->nullable()->constrained();
            $table->text('duties_and_responsibilities')->nullable();
            $table->text('deliverables')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_profile_duties');
    }
};
