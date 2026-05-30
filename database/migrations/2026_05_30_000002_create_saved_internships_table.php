<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_internships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_profile_id')->constrained('student_profiles')->cascadeOnDelete();
            $table->foreignId('internship_id')->constrained('internships')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['student_profile_id', 'internship_id']);
            $table->index(['student_profile_id', 'created_at']);
            $table->index(['internship_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_internships');
    }
};
