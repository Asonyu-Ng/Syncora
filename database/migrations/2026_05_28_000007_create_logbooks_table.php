<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained('internships')->cascadeOnDelete();
            $table->foreignId('student_profile_id')->constrained('student_profiles')->cascadeOnDelete();
            $table->date('entry_date');
            $table->text('content');
            $table->string('status', 50)->default('submitted');
            $table->foreignId('approved_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->unique(['internship_id', 'student_profile_id', 'entry_date']);
            $table->index(['status', 'entry_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};

