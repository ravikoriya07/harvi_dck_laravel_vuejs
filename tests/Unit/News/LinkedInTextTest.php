<?php

namespace Tests\Unit\News;

use App\Services\News\LinkedInText;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class LinkedInTextTest extends TestCase
{
    /**
     * @return array<string, array{0: string|null, 1: string|null}>
     */
    public static function commentary(): array
    {
        return [
            'hashtag template'  => ['Great day {hashtag|\#|construction}', 'Great day #construction'],
            'organisation tag'  => ['Thanks @[Haringey Council](urn:li:organization:2414183)!', 'Thanks Haringey Council!'],
            'member tag'        => ['Welcome @[Jane Smith](urn:li:person:5abc_dEfgH)', 'Welcome Jane Smith'],
            'escaped reserved'  => ['Phase 2 \(complete\) \- 100\% \@ site \[A\]', 'Phase 2 (complete) \- 100\% @ site [A]'],
            'escaped backslash' => ['C:\\\\temp', 'C:\temp'],
            'line breaks kept'  => ["Line one\nLine two", "Line one\nLine two"],
            'blank'             => ['   ', null],
            'null'              => [null, null],
        ];
    }

    #[DataProvider('commentary')]
    public function test_little_text_is_converted_to_plain_text(?string $input, ?string $expected): void
    {
        $this->assertSame($expected, LinkedInText::toPlain($input));
    }
}
