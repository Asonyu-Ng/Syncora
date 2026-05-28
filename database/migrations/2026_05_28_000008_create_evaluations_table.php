<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained('internships')->cascadeOnDelete();
            $table->foreignId('student_profile_id')->constrained('student_profiles')->cascadeOnDelete();
            $table->foreignId('evaluator_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('type', 50)->nullable();
            $table->unsignedTinyInteger('score')->nullable();
            $table->text('comments')->nullable();
            $table->timestamp('evaluated_at')->nullable();
            $table->timestamps();

            $table->index(['internship_id', 'student_profile_id']);
            $table->index('evaluated_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};

