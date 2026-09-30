<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_posts', function (Blueprint $table) {
            $table->id();
            $table->string('platform', 20);
            $table->string('external_id', 191);
            $table->string('permalink', 1000);
            $table->text('caption')->nullable();
            $table->string('media_type', 20)->default('text');
            // Stable identity of the preview image (LinkedIn asset URN / Instagram CDN path)
            $table->string('media_key', 512)->nullable();
            // Local copy on the public disk (remote URLs expire)
            $table->string('image_path')->nullable();
            // Last remote preview URL, used only while no local copy exists
            $table->text('image_source_url')->nullable();
            $table->text('image_alt')->nullable();
            $table->char('content_hash', 64);
            $table->timestamp('published_at')->index();
            $table->timestamp('source_updated_at')->nullable();
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Includes soft-deleted rows: a post that reappears is restored, never duplicated
            $table->unique(['platform', 'external_id']);
            $table->index(['deleted_at', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_posts');
    }
};
