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
        Schema::table('function_parameters', function (Blueprint $table) {
            // If the old column exists, drop its foreign key and column first
            if (Schema::hasColumn('function_parameters', 'subfunction_position_id')) {
                try {
                    $table->dropForeign(['subfunction_position_id']);
                } catch (\Exception $e) {
                    // ignore if the foreign key does not exist or has a different name
                }

                try {
                    $table->dropColumn('subfunction_position_id');
                } catch (\Exception $e) {
                    // ignore if column can't be dropped for some reason
                }
            }

            // Add the new foreign id to subfunction_descriptions. Make it nullable to
            // avoid breaking inserts during the migration/seed process; callers can
            // populate it afterward.
            if (!Schema::hasColumn('function_parameters', 'subfunction_description_id')) {
                $table->foreignId('subfunction_description_id')
                    ->nullable()
                    ->constrained('subfunction_descriptions')
                    ->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('function_parameters', function (Blueprint $table) {
            // Remove the new column if present
            if (Schema::hasColumn('function_parameters', 'subfunction_description_id')) {
                try {
                    $table->dropForeign(['subfunction_description_id']);
                } catch (\Exception $e) {
                    // ignore if foreign key not found
                }

                try {
                    $table->dropColumn('subfunction_description_id');
                } catch (\Exception $e) {
                    // ignore if column can't be dropped
                }
            }

            // Recreate the old column to restore previous state (nullable to be safe)
            if (!Schema::hasColumn('function_parameters', 'subfunction_position_id')) {
                $table->foreignId('subfunction_position_id')
                    ->nullable()
                    ->constrained('subfunction_positions')
                    ->onDelete('cascade')
                    ->after('id');
            }
        });
    }
};
