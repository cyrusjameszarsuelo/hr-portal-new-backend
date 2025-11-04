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
        Schema::create('jp_description_kras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_description_id')->constrained('jp_descriptions')->cascadeOnDelete();
            $table->text('kra_description');
            $table->text('deliverables');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::dropIfExists('jp_description_kras');
    }
};
