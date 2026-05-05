<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('job_listings')->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->longText('cover_letter');
            $table->string('resume_path');
            $table->string('resume_original_name');
            $table->timestamps();

            $table->unique(['job_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
