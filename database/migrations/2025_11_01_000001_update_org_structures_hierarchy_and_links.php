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
        Schema::table('org_structures', function (Blueprint $table) {
            $table->dropColumn(['pid']);
            $table->unsignedBigInteger('pid')->nullable();
            $table->foreign('pid')->references('id')->on('org_structures')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->after('pid')->constrained('users')->nullOnDelete();
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('org_structures', function (Blueprint $table) {
            // Drop indexes first
            $table->dropIndex(['email']);
            $table->dropUnique(['emp_no']);
            
            // Drop foreign keys and columns
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            
            // Drop the foreign key constraint on pid
            $table->dropForeign(['pid']);
        });
    }
};
