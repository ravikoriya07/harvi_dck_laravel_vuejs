<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('value')->nullable()->after('image');
            $table->string('date')->nullable()->after('value');
            $table->string('status')->nullable()->after('date');
            $table->string('client')->nullable()->after('status');
            $table->text('scope')->nullable()->after('client');
            $table->longText('description')->nullable()->after('scope');
            $table->json('gallery')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['value', 'date', 'status', 'client', 'scope', 'description', 'gallery']);
        });
    }
};
