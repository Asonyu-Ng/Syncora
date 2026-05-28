<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_profile_id')->constrained('company_profiles')->cascadeOnDelete();
            $table->foreignId('supervisor_profile_id')->nullable()->constrained('supervisor_profiles')->nullOnDelete();
            $table->string('title');
            $table->string('location')->nullable();
            $table->string('type', 50)->nullable();
            $table->string('duration', 50)->nullable();
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status', 50)->default('open');
            $table->timestamps();

            $table->index(['company_profile_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};

