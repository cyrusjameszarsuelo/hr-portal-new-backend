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
        Schema::create('function_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subfunction_description_id')->nullable()->constrained('subfunction_descriptions')->cascadeOnDelete();
            $table->string('deliverable');
            $table->string('frequency_deliverable');
            $table->string('responsible');
            $table->string('accountable');
            $table->string('support')->nullable();
            $table->string('consulted')->nullable();
            $table->string('informed')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('function_parameters');
    }
};
