<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['title' => 'London Borough of Haringey - Kitchen & Bathroom Refurbishment', 'category' => 'Refurbishment', 'slug' => 'london-borough-of-haringey-kitchen-bathroom-refurbishment', 'image' => '/assets/images/DCK-Northumberland-Park-15-3-600x600.png'],
            ['title' => 'LB Haringey - Void Refurbishment', 'category' => 'Refurbishment', 'slug' => 'lb-haringey-void-refurbishment', 'image' => '/assets/images/WhatsApp-Image-2025-09-25-at-15.46.02_0bb1e965-600x600.jpg'],
            ['title' => 'LB Hackney - Void Full Refurbishment Programme', 'category' => 'Refurbishment', 'slug' => 'lb-hackney-void-full-refurbishment-programme', 'image' => '/assets/images/WhatsApp-Image-2025-09-25-at-15.45.01_27d90c71-600x600.jpg'],
            ['title' => 'Extension and Refurbishment Project | LB Haringey', 'category' => 'Refurbishment', 'slug' => 'extension-and-refurbishment-project-lb-haringey', 'image' => '/assets/images/WhatsApp-Image-2025-09-25-at-15.41.48_402f275d-600x600.jpg'],
            ['title' => 'Haringey Aids & Adaptations Works', 'category' => 'Aids and adaptations', 'slug' => 'haringey-aids-adaptations-works', 'image' => '/assets/images/6509ab55-97be-4536-9747-018df8c0a9f5-600x600.jpg'],
            ['title' => 'Harrow Aids & Adaptations Works', 'category' => 'Aids and adaptations', 'slug' => 'harrow-aids-adaptations-works', 'image' => '/assets/images/0ab4bbf9-2f9c-42f1-b604-0c4230f95d6a-600x600.jpg'],
            ['title' => 'Aids & Adaptations, London Borough of Haringey', 'category' => 'Aids and adaptations', 'slug' => 'aids-adaptations-london-borough-of-haringey', 'image' => '/assets/images/LAS1-1-600x600.jpg'],
            ['title' => 'Southwark Void Refurbishment Programme 2025', 'category' => 'Construction', 'slug' => 'southwark-void-refurbishment-programme-2025', 'image' => '/assets/images/Untitled-design-1-1-600x600.png'],
            ['title' => 'Extension Project, Cuffley', 'category' => 'Construction', 'slug' => 'extension-project-cuffley', 'image' => '/assets/images/main-600x600.jpeg'],
            ['title' => 'Seething Wells Campus, Kingston University', 'category' => 'Construction', 'slug' => 'seething-wells-campus-kingston-university', 'image' => '/assets/images/IMG1-1-1-600x600.png'],
            ['title' => 'Seafront Hotel, Brighton', 'category' => 'Construction', 'slug' => 'seafront-hotel-brighton', 'image' => '/assets/images/Untitled-design-2-1-600x600.png'],
            ['title' => 'Great Arthur House, City of London', 'category' => 'Construction', 'slug' => 'great-arthur-house-city-of-london', 'image' => '/assets/images/image_3-7-1-600x600.png'],
            ['title' => 'Haringey Broadwater Farm Estate Fire Safety Works & Communal Decorations', 'category' => 'Construction', 'slug' => 'designer-apartment', 'image' => '/assets/images/JOB-70-of-155-scaled-600x600.jpg'],
            ['title' => 'Haringey Broadwater Farm Community Centre', 'category' => 'Construction', 'slug' => 'haringey-broadwater-farm-community-centre', 'image' => '/assets/images/projects/1/DCK-Broadwater-Farm-Community-Project-01-600x600.png'],
            ['title' => 'Void Property Renovations, London Borough of Haringey', 'category' => 'Construction', 'slug' => 'void-property-renovations-london-borough-of-haringey', 'image' => '/assets/images/WhatsApp-Image-2025-09-25-at-15.37.48_3369e48e-600x600.jpg'],
            ['title' => 'Void Property Renovations, Ministry of Defence', 'category' => 'Construction', 'slug' => 'void-property-renovations-ministry-of-defence', 'image' => '/assets/images/main-9-600x600.jpg'],
            ['title' => 'Kitchens & Bathrooms, London Borough of Haringey', 'category' => 'Construction', 'slug' => 'kitchens-bathrooms-london-borough-of-haringey', 'image' => '/assets/images/5-3-600x600.png'],
            ['title' => 'Haringey Kitchens & Bathrooms 2024 Programme', 'category' => 'Construction', 'slug' => 'haringey-kitchens-bathrooms-2024-programme', 'image' => '/assets/images/71bfe462-bc1a-4842-8e7e-abbe413f4e59-600x600.jpg'],
            ['title' => 'Haringey Community Benefit Society (HCBS) Voids Refurbishment Works', 'category' => 'Construction', 'slug' => 'haringey-community-benefit-society-hcbs-voids-refurbishment-works', 'image' => '/assets/images/2-5-600x600.png'],
            ['title' => 'Hackney Capital Works Programme Refurbishment', 'category' => 'Construction', 'slug' => 'hackney-capital-works-programme-refurbishment', 'image' => '/assets/images/1-8-600x600.png'],
        ];

        foreach ($rows as $index => $row) {
            Project::updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'title' => $row['title'],
                    'category' => $row['category'],
                    'image' => $row['image'],
                    'sort_order' => $index,
                ]
            );
        }
    }
}
