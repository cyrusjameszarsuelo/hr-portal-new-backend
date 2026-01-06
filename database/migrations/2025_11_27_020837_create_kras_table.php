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
        Schema::create('kras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subfunction_position_id')->nullable()->constrained();
            $table->string('department');
            $table->string('business_unit');
            $table->string('kra');
            $table->text('kra_description')->nullable();
            $table->foreignId('position_title_id')->nullable()->constrained('position_titles')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kras');
    }
};
