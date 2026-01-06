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
        Schema::table('a_abouts', function (Blueprint $table) {
            if (!Schema::hasColumn('a_abouts', 'firstname')) {
                $table->string('firstname')->nullable()->after('employee_id');
            }
            if (!Schema::hasColumn('a_abouts', 'middlename')) {
                $table->string('middlename')->nullable()->after('firstname');
            }
            if (!Schema::hasColumn('a_abouts', 'lastname')) {
                $table->string('lastname')->nullable()->after('middlename');
            }
            if (!Schema::hasColumn('a_abouts', 'suffix')) {
                $table->string('suffix')->nullable()->after('lastname');
            }
            if (!Schema::hasColumn('a_abouts', 'birthdate')) {
                $table->date('birthdate')->nullable()->after('birth_date');
            }
            if (!Schema::hasColumn('a_abouts', 'number_of_children')) {
                $table->integer('number_of_children')->nullable()->after('civil_status');
            }
            if (!Schema::hasColumn('a_abouts', 'personal_email')) {
                $table->string('personal_email')->nullable()->after('phone_number');
            }
            if (!Schema::hasColumn('a_abouts', 'upload_photo')) {
                $table->string('upload_photo')->nullable()->after('personal_email');
            }
            if (!Schema::hasColumn('a_abouts', 'current_address_province')) {
                $table->string('current_address_province')->nullable()->after('current_address_region');
            }
            if (!Schema::hasColumn('a_abouts', 'current_address_barangay')) {
                $table->string('current_address_barangay')->nullable()->after('current_address_street');
            }
            if (!Schema::hasColumn('a_abouts', 'permanent_address_barangay')) {
                $table->string('permanent_address_barangay')->nullable()->after('permanent_address_street');
            }
            if (!Schema::hasColumn('a_abouts', 'permanent_address_province')) {
                $table->string('permanent_address_province')->nullable()->after('permanent_address_region');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('a_abouts', function (Blueprint $table) {
            foreach (['firstname','middlename','lastname','suffix','birthdate','number_of_children','personal_email','upload_photo','current_address_barangay','permanent_address_barangay'] as $col) {
                if (Schema::hasColumn('a_abouts', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
