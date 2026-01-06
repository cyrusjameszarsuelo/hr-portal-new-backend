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
        Schema::table('org_structures', function (Blueprint $table) {
            $table->boolean('dept_head')->default(0)->after('level');
            $table->boolean('is_admin')->default(0)->after('dept_head');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('org_structures', function (Blueprint $table) {
            $table->dropColumn(['dept_head', 'is_admin']);
        });
    }
};
