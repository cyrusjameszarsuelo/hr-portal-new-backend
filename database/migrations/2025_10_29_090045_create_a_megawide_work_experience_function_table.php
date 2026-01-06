<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('a_megawide_work_experience_function', function (Blueprint $table) {
            $table->id();
            $table->foreignId('megawide_work_experience_id')
                ->constrained('a_megawide_work_experiences', 'id', 'a_mw_exp_func_mw_exp_id_fk')
                ->cascadeOnDelete();
            $table->foreignId('subfunction_position_id')
                ->constrained('subfunction_positions', 'id', 'a_mw_exp_func_subfunc_id_fk')
                ->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['megawide_work_experience_id', 'subfunction_position_id'], 'a_mw_exp_func_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('a_megawide_work_experience_function');
    }
};
