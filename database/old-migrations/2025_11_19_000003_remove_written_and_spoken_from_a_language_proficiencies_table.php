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
        Schema::table('a_language_proficiencies', function (Blueprint $table) {
            if (Schema::hasColumn('a_language_proficiencies', 'written')) {
                $table->dropColumn('written');
            }
            if (Schema::hasColumn('a_language_proficiencies', 'spoken')) {
                $table->dropColumn('spoken');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('a_language_proficiencies', function (Blueprint $table) {
            if (!Schema::hasColumn('a_language_proficiencies', 'written')) {
                $table->boolean('written')->default(false)->after('language');
            }
            if (!Schema::hasColumn('a_language_proficiencies', 'spoken')) {
                $table->boolean('spoken')->default(false)->after('w_prof');
            }
        });
    }
};
