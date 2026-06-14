<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('internships', function (Blueprint $table): void {
            $table->string('department')->nullable()->after('title');
            $table->string('education_level')->nullable()->after('description');
            $table->text('other_requirements')->nullable()->after('education_level');
            $table->json('required_skills')->nullable()->after('other_requirements');
        });
    }

    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table): void {
            $table->dropColumn([
                'department',
                'education_level',
                'other_requirements',
                'required_skills',
            ]);
        });
    }
};
