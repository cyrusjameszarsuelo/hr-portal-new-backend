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
        Schema::create('subfunction_descriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subfunction_position_id')->nullable()->constrained()->onDelete('set null');
            $table->text('description');
            $table->integer('order_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subfunction_descriptions');
    }
};
