<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_value_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('social_value_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['social_value_id', 'path']);
            $table->index(['social_value_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_value_images');
    }
};
