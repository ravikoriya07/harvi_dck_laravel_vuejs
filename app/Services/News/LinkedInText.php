<?php

namespace App\Services\News;

/**
 * LinkedIn returns post commentary in its "little" text format: hashtags and
 * mentions are templates and reserved characters are backslash-escaped.
 * Convert it to the plain text a reader sees on LinkedIn.
 *
 * @see https://learn.microsoft.com/en-us/linkedin/marketing/community-management/shares/little-text-format
 */
final class LinkedInText
{
    public static function toPlain(?string $text): ?string
    {
        if ($text === null) {
            return null;
        }

        // {hashtag|\#|coding} → #coding
        $text = preg_replace('/\{hashtag\|\\\\?#\|([^}]*)\}/u', '#$1', $text) ?? $text;

        // @[DCK Construction](urn:li:organization:123) → DCK Construction
        $text = preg_replace('/@\[((?:\\\\.|[^\]\\\\])*)\]\(urn:li:[^)]+\)/u', '$1', $text) ?? $text;

        // \( \) \[ \] \{ \} \< \> \@ \| \# \* \_ \~ \\ → literal character
        $text = preg_replace('/\\\\([\\\\|{}@\[\]()<>#*_~])/u', '$1', $text) ?? $text;

        $text = trim($text);

        return $text === '' ? null : $text;
    }
}
