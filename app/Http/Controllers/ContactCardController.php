<?php

namespace App\Http\Controllers;

use App\Models\ContactCard;
use Inertia\Inertia;
use Inertia\Response;

class ContactCardController extends Controller
{
    public function show(string $slug): Response
    {
        $card = ContactCard::where('slug', $slug)->firstOrFail();

        return Inertia::render('ContactCard', [
            'card' => [
                'name' => $card->name,
                'designation' => $card->designation,
                'company_name' => $card->company_name,
                'email' => $card->email,
                'phone' => $card->phone,
                'website' => $card->website,
                'office_address' => $card->office_address,
                'profile_image' => $card->profile_image
                    ? asset('storage/'.$card->profile_image)
                    : null,
                'slug' => $card->slug,
            ],
        ]);
    }
}
