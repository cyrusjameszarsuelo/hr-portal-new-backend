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
        Schema::table('a_prev_work_experiences', function (Blueprint $table) {
            if (!Schema::hasColumn('a_prev_work_experiences', 'megawide_equivalent')) {
                $table->string('megawide_equivalent')->nullable()->after('company');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('a_prev_work_experiences', function (Blueprint $table) {
            if (Schema::hasColumn('a_prev_work_experiences', 'megawide_equivalent')) {
                $table->dropColumn('megawide_equivalent');
            }
        });
    }
};
