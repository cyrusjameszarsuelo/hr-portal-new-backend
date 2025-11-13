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
        Schema::create('job_profile_kras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subfunction_position_id')->nullable()->constrained();
            $table->string('department');
            $table->string('business_unit');
            $table->string('kra');
            $table->text('kra_description')->nullable();
            $table->text('roles')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_profile_kras');
    }
};
