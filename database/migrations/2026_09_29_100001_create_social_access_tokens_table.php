<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('platform', 20)->unique();
            // Encrypted with APP_KEY (model casts)
            $table->text('access_token');
            $table->text('refresh_token')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('refresh_token_expires_at')->nullable();
            // Fingerprint of the .env credentials this row was seeded from
            $table->char('seed_hash', 64);
            $table->timestamp('last_refreshed_at')->nullable();
            $table->timestamp('last_refresh_attempt_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_access_tokens');
    }
};
