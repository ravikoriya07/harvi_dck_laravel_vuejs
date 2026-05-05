<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class JobApplicationResumeController extends Controller
{
    public function __invoke(JobApplication $jobApplication): StreamedResponse
    {
        abort_unless(Storage::disk('public')->exists($jobApplication->resume_path), 404);

        return Storage::disk('public')->download(
            $jobApplication->resume_path,
            $jobApplication->resume_original_name
        );
    }
}
