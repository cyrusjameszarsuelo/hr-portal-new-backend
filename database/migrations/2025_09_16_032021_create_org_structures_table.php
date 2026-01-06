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
            $table->foreignId('position_title_id')->nullable()->constrained('position_titles')->onDelete('set null');
            $table->unsignedBigInteger('reporting')->nullable();
            $table->foreign('reporting')->references('id')->on('org_structures')->nullOnDelete();
            $table->string('emp_no')->nullable();
            $table->foreignId('level_id')->nullable()->constrained('levels')->onDelete('set null');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->foreignId('sbu_id')->nullable()->constrained('sbus')->onDelete('set null');
            $table->boolean('dept_head')->default(0);
            $table->boolean('is_admin')->default(0);
            $table->string('company');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('pid')->nullable();
            $table->foreign('pid')->references('id')->on('org_structures')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('email');
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
