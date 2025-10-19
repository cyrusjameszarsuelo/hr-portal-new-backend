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
        Schema::table('function_positions', function (Blueprint $table) {
            $table->string('order_id')->nullable()->after('name');
        });

        Schema::table('subfunction_positions', function (Blueprint $table) {
            $table->string('order_id')->nullable()->after('name');
        });

        Schema::table('subfunction_descriptions', function (Blueprint $table) {
            $table->string('order_id')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
