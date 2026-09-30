<?php

namespace App\Enums;

use App\Services\News\InstagramFeedClient;
use App\Services\News\LinkedInFeedClient;
use App\Services\News\SocialFeedClient;

enum SocialPlatform: string
{
    case LinkedIn  = 'linkedin';
    case Instagram = 'instagram';

    public function label(): string
    {
        return match ($this) {
            self::LinkedIn  => 'LinkedIn',
            self::Instagram => 'Instagram',
        };
    }

    /**
     * @return class-string<SocialFeedClient>
     */
    public function clientClass(): string
    {
        return match ($this) {
            self::LinkedIn  => LinkedInFeedClient::class,
            self::Instagram => InstagramFeedClient::class,
        };
    }
}
