<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('internship_id')->nullable()->constrained('internships')->nullOnDelete();
            $table->foreignId('student_profile_id')->nullable()->constrained('student_profiles')->nullOnDelete();
            $table->string('name');
            $table->string('type', 50)->nullable();
            $table->string('status', 50)->default('ready');
            $table->longText('content')->nullable();
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};

