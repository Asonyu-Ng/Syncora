<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained('internships')->cascadeOnDelete();
            $table->foreignId('student_profile_id')->nullable()->constrained('student_profiles')->nullOnDelete();
            $table->foreignId('assigned_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status', 50)->default('todo');
            $table->timestamp('due_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['internship_id', 'status']);
            $table->index('due_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

