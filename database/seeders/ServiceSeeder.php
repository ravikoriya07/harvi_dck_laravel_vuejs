<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title'       => 'Structural Works',
                'slug'        => 'architecture-services',
                'description' => 'Structural Works Division delivers reliable, safe, and fully compliant structural solutions for residential, commercial, and public-sector projects.',
                'image'       => '/assets/images/bg-3-795x653.avif',
                'image_alt'   => 'construction silhouette',
            ],
            [
                'title'       => 'Disrepairs / Responsive',
                'slug'        => 'disrepair',
                'description' => 'We provide a comprehensive Disrepair and Responsive Maintenance Service designed to resolve property issues quickly, efficiently, and to the highest standard.',
                'image'       => '/assets/images/image-2-795x475.avif',
                'image_alt'   => 'image-2',
            ],
            [
                'title'       => 'Loft / Extension',
                'slug'        => 'loft-extension',
                'description' => 'We specialise in creating additional living space through expertly designed loft conversions and house extensions.',
                'image'       => '/assets/images/image_1-768x653.avif',
                'image_alt'   => 'image_1',
            ],
            [
                'title'       => 'Roofing Works',
                'slug'        => 'roofing',
                'description' => 'We deliver specialist roofing works, including full roof replacements, structural repairs, and weatherproofing solutions.',
                'image'       => '/assets/images/Gemini_Generated_Image_q882q7q882q7q882-e1762265925894-795x608.avif',
                'image_alt'   => 'Roofing Works',
            ],
            [
                'title'       => 'Aids and Adaptations',
                'slug'        => 'adaptions',
                'description' => 'We provide specialist mobility adaptations, including Level Access Showers, disabled access ramps, and lifting solutions.',
                'image'       => '/assets/images/LAS18-795x653.avif',
                'image_alt'   => 'LAS18',
            ],
            [
                'title'       => 'Fire Safety Works',
                'slug'        => 'fire-safety',
                'description' => 'DCK delivers comprehensive fire safety solutions, including fire door installations, compartmentation works, and fire-stopping measures.',
                'image'       => '/assets/images/JOB-17-of-155-scaled-795x653.avif',
                'image_alt'   => 'Fire Safety Works',
            ],
            [
                'title'       => 'Refurbishment / General Build',
                'slug'        => 'general-build',
                'description' => 'We have vast experience of delivering high-quality construction projects in several specialist sectors with strong client partnerships.',
                'image'       => '/assets/images/image_5-4-795x653.avif',
                'image_alt'   => 'Refurbishment / General Build',
            ],
        ];

        foreach ($services as $index => $service) {
            Service::query()->updateOrCreate(
                ['slug' => $service['slug']],
                [
                    'title'       => $service['title'],
                    'description' => $service['description'],
                    'image'       => $service['image'],
                    'image_alt'   => $service['image_alt'],
                    'sort_order'  => $index,
                ],
            );
        }
    }
}
