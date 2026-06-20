<?php

namespace Database\Seeders;

use App\Enums\BlogStatus;
use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'sort_order'   => 0,
                'title'        => 'Conversation with the CEO | DCK Construction',
                'slug'         => 'conversation-with-the-ceo-dck-construction',
                'image_path'   => 'blogs/Screenshot-2026-02-10-083321-810x385.avif',
                'video_url'    => 'https://www.youtube.com/watch?v=YHdujsohPMs',
                'author'       => 'Ramil Veliiev',
                'category'     => 'YouTube',
                'excerpt'      => 'Conversation with the CEO of DCK Construction focused on delivery quality, project standards, and ongoing housing refurbishment programs.',
                'content'      => null,
                'status'       => BlogStatus::Published->value,
                'published_at' => '2026-02-10 00:00:00',
            ],
            [
                'sort_order'   => 1,
                'title'        => 'DCK Construction: Newham Voids Works Overview',
                'slug'         => 'dck-construction-newham-voids-works-overview',
                'image_path'   => 'blogs/Screenshot-2026-02-10-082902-810x385.avif',
                'video_url'    => 'https://www.youtube.com/watch?v=N5nPA0qzZBY',
                'author'       => 'Ramil Veliiev',
                'category'     => 'YouTube',
                'excerpt'      => 'Overview of Newham voids works, scope planning, and delivery outcomes for occupied and vacant property turnaround.',
                'content'      => null,
                'status'       => BlogStatus::Published->value,
                'published_at' => '2026-02-10 00:00:00',
            ],
            [
                'sort_order'   => 2,
                'title'        => 'DCK Construction Working with Camden Council | Fire Door Installation',
                'slug'         => 'dck-construction-working-with-camden-council-fire-door-installation',
                'image_path'   => 'blogs/Screenshot-2026-01-06-161416-810x385.avif',
                'video_url'    => 'https://www.youtube.com/watch?v=iIU15suqnR0',
                'author'       => 'Ramil Veliiev',
                'category'     => 'YouTube',
                'excerpt'      => 'A look at fire door installation delivery in collaboration with Camden Council and compliance-led execution on site.',
                'content'      => null,
                'status'       => BlogStatus::Published->value,
                'published_at' => '2026-01-06 00:00:00',
            ],
            [
                'sort_order'   => 3,
                'title'        => 'Kitchen & Bathroom Renewal Programme - Delivering Quality Upgrades for Haringey Homes',
                'slug'         => 'kitchen-bathroom-renewal-programme-delivering-quality-upgrades-for-haringey-homes',
                'image_path'   => 'blogs/Screenshot-2026-01-06-161032-810x385.avif',
                'video_url'    => 'https://www.youtube.com/watch?v=GJm6oqf9_bE',
                'author'       => 'Ramil Veliiev',
                'category'     => 'YouTube',
                'excerpt'      => 'Programme highlights from kitchen and bathroom upgrades delivered for Haringey homes with tenant-focused execution.',
                'content'      => null,
                'status'       => BlogStatus::Published->value,
                'published_at' => '2026-01-06 00:00:00',
            ],
        ];

        foreach ($posts as $data) {
            Blog::updateOrCreate(
                ['slug' => $data['slug']],
                $data,
            );
        }
    }
}
