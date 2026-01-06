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
        Schema::create('org_structures', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->string('firstname');
            $table->string('lastname');
            $table->string('nickname')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('position_title');
            $table->string('reporting');
            $table->unsignedBigInteger('pid')->nullable();
            $table->string('emp_no')->nullable();
            $table->string('level');
            $table->string('department');
            $table->string('business_unit');
            $table->string('company');
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_structures');
    }
};
