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
        Schema::table('users', function (Blueprint $table) {
            $table->string('microsoft_id', 64)->nullable()->unique()->after('password');
            $table->string('sso_provider')->default('azure')->after('microsoft_id');
            $table->timestamp('last_login_at')->nullable()->after('sso_provider');
            $table->string('avatar')->nullable()->after('last_login_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar',
                'last_login_at',
                'sso_provider',
                'microsoft_id'
            ]);
        });
    }
};
