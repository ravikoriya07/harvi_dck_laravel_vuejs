<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class JobApplicationController extends Controller
{
    public function store(Request $request, Job $job): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('job_applications', 'email')->where(fn ($query) => $query->where('job_id', $job->id)),
            ],
            'phone' => ['required', 'string', 'max:50'],
            'cover_letter' => ['required', 'string', 'max:10000'],
            'resume' => ['required', 'file', 'mimes:pdf,doc,docx,odt,rtf,txt', 'max:5120'],
        ], [
            'email.unique' => 'You have already applied for this job with this email.',
            'resume.max' => 'Resume file size must not exceed 5MB.',
        ]);

        $resume = $validated['resume'];
        $storedPath = Storage::disk('public')->putFile('job-applications/resumes', $resume);

        try {
            JobApplication::create([
                'job_id' => $job->id,
                'name' => $validated['name'],
                'email' => strtolower(trim($validated['email'])),
                'phone' => $validated['phone'],
                'cover_letter' => $validated['cover_letter'],
                'resume_path' => $storedPath,
                'resume_original_name' => $resume->getClientOriginalName(),
            ]);
        } catch (QueryException $exception) {
            if ((string) $exception->getCode() === '23000') {
                return response()->json([
                    'message' => 'You have already applied for this job with this email.',
                    'errors' => [
                        'email' => ['You have already applied for this job with this email.'],
                    ],
                ], 422);
            }

            throw $exception;
        }

        return response()->json([
            'message' => 'Application submitted successfully.',
        ], 201);
    }
}
