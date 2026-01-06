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
        Schema::create('a_abouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_structure_id')->constrained('org_structures')->cascadeOnDelete();

            // Personal Information
            $table->string('employee_id')->nullable();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->string('suffix')->nullable();
            $table->string('nickname')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('gender')->nullable();
            $table->string('civil_status')->nullable();
            $table->integer('number_of_children')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('upload_photo')->nullable();
            $table->string('blood_type')->nullable();

            // Emergency Contact Information
            $table->string('emergency_contact_name')->nullable();
            $table->string('relationship_to_employee')->nullable();
            $table->string('emergency_contact_number')->nullable();

            // Citizenship and Birth Place
            $table->string('citizenship')->nullable();
            $table->string('birth_place')->nullable();

            // Current Address
            $table->string('current_address_street')->nullable();
            $table->string('current_address_barangay')->nullable();
            $table->string('current_address_city')->nullable();
            $table->string('current_address_province')->nullable();
            $table->string('current_address_region')->nullable();
            $table->string('current_address_zip_code')->nullable();

            // Permanent Address
            $table->string('permanent_address_street')->nullable();
            $table->string('permanent_address_barangay')->nullable();
            $table->string('permanent_address_city')->nullable();
            $table->string('permanent_address_province')->nullable();
            $table->string('permanent_address_region')->nullable();
            $table->string('permanent_address_zip_code')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_abouts');
    }
};
