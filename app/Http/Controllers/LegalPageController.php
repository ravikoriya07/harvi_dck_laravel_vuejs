<?php

namespace App\Http\Controllers;

use App\Models\LegalPage;
use Inertia\Inertia;
use Inertia\Response;

class LegalPageController extends Controller
{
    /**
     * The slug comes from the route's defaults (see routes/web.php), not the URL.
     */
    public function show(string $slug): Response
    {
        $page = LegalPage::query()->where('slug', $slug)->firstOrFail();

        return Inertia::render('LegalPage', [
            'page' => $page->toPagePayload(),
        ]);
    }
}
