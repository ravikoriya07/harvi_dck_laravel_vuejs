<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Admin-editable legal page (Terms of Use, Privacy Policy). Rows are seeded by migration and
 * each slug has a fixed public route, so pages are edited but never created or deleted.
 */
class LegalPage extends Model
{
    public const TERMS_OF_USE = 'terms-of-use';

    public const PRIVACY_POLICY = 'privacy-policy';

    protected $fillable = [
        'title',
        'intro',
        'sections',
        'meta_description',
        'last_updated_at',
    ];

    protected function casts(): array
    {
        return [
            'sections' => 'array',
            'last_updated_at' => 'date',
        ];
    }

    public function getPathAttribute(): string
    {
        return '/' . $this->slug;
    }

    /**
     * @return array{
     *     title: string,
     *     path: string,
     *     meta_description: ?string,
     *     last_updated: ?string,
     *     last_updated_iso: ?string,
     *     intro: string,
     *     sections: list<array{id: string, heading: string, body: string}>
     * }
     */
    public function toPagePayload(): array
    {
        return [
            'title' => $this->title,
            'path' => $this->path,
            'meta_description' => $this->meta_description,
            'last_updated' => $this->last_updated_at?->format('j F Y'),
            'last_updated_iso' => $this->last_updated_at?->toDateString(),
            'intro' => self::sanitize($this->intro),
            'sections' => $this->sectionsPayload(),
        ];
    }

    /**
     * Sanitised sections, each with a unique anchor id for the "On this page" menu.
     *
     * @return list<array{id: string, heading: string, body: string}>
     */
    private function sectionsPayload(): array
    {
        $sections = [];
        $usedIds = [];

        foreach ($this->sections ?? [] as $section) {
            $heading = trim((string) ($section['heading'] ?? ''));

            if ($heading === '') {
                continue;
            }

            $baseId = Str::slug($heading) ?: 'section-' . (count($sections) + 1);
            $id = $baseId;

            for ($suffix = 2; isset($usedIds[$id]); $suffix++) {
                $id = $baseId . '-' . $suffix;
            }

            $usedIds[$id] = true;

            $sections[] = [
                'id' => $id,
                'heading' => $heading,
                'body' => self::sanitize($section['body'] ?? null),
            ];
        }

        return $sections;
    }

    /**
     * Rich-editor HTML is rendered with v-html, so strip scripts, event handlers and unsafe URLs.
     */
    private static function sanitize(?string $html): string
    {
        return blank($html) ? '' : trim(Str::sanitizeHtml($html));
    }
}
