<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained('internships')->cascadeOnDelete();
            $table->foreignId('student_profile_id')->constrained('student_profiles')->cascadeOnDelete();
            $table->string('status', 50)->default('applied');
            $table->text('cover_letter')->nullable();
            $table->json('payload')->nullable();
            $table->timestamp('decided_at')->nullable();
            $table->timestamps();

            $table->unique(['internship_id', 'student_profile_id']);
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};

