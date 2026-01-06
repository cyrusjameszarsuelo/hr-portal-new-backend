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
            $table->string('support')->nullable()->change();
            $table->string('consulted')->nullable()->change();
            $table->string('informed')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('function_parameters', function (Blueprint $table) {
            $table->string('support')->nullable(false)->change();
            $table->string('consulted')->nullable(false)->change();
            $table->string('informed')->nullable(false)->change();
        });
    }
};
