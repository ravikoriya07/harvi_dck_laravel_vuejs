<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\ContactCard;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Service;
use App\Models\SocialValue;
use App\Models\SocialValueImage;
use App\Models\TeamMember;
use App\Observers\AvifImageObserver;
use App\Services\AvifConversionService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AvifConversionService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        $observer = $this->app->make(AvifImageObserver::class);

        Project::saved(fn (Project $project) => $observer->saved($project));
        ProjectImage::saved(fn (ProjectImage $image) => $observer->saved($image));
        SocialValue::saved(fn (SocialValue $socialValue) => $observer->saved($socialValue));
        SocialValueImage::saved(fn (SocialValueImage $image) => $observer->saved($image));
        TeamMember::saved(fn (TeamMember $member) => $observer->saved($member));
        Service::saved(fn (Service $service) => $observer->saved($service));
        Blog::saved(fn (Blog $blog) => $observer->saved($blog));
        ContactCard::saved(fn (ContactCard $card) => $observer->saved($card));
    }
}
