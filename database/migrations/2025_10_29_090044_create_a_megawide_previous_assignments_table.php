<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('a_megawide_previous_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('megawide_work_experience_id')
                ->constrained('a_megawide_work_experiences', 'id', 'a_mw_prev_assign_mw_exp_id_fk')
                ->cascadeOnDelete();
            $table->foreignId('sbu_id')->nullable()->constrained('sbus')->onDelete('set null');
            $table->boolean('worked_in_megawide')->default(true);
            $table->string('previous_department')->nullable();
            $table->string('previous_job_title')->nullable();
            $table->date('previous_role_start_date')->nullable();
            $table->date('end_of_assignment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('a_megawide_previous_assignments');
    }
};
