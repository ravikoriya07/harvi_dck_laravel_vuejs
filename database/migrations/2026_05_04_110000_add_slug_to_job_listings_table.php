<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
        });

        // Backfill slugs for existing rows
        $jobs = DB::table('job_listings')->orderBy('id')->get(['id', 'title']);

        foreach ($jobs as $job) {
            $base = Str::slug($job->title) ?: 'job';
            $slug = $base;
            $i    = 1;

            while (DB::table('job_listings')->where('slug', $slug)->where('id', '!=', $job->id)->exists()) {
                $slug = $base . '-' . $i++;
            }

            DB::table('job_listings')->where('id', $job->id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
