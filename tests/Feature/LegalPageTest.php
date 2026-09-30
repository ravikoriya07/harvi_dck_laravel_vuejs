<?php

namespace Tests\Feature;

use App\Filament\Admin\Resources\LegalPages\LegalPageResource;
use App\Filament\Admin\Resources\LegalPages\Pages\EditLegalPage;
use App\Models\LegalPage;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\Repeater;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Livewire\Livewire;
use Tests\TestCase;

class LegalPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel('admin');
    }

    public function test_terms_of_use_page_renders_seeded_content(): void
    {
        $this->get('/terms-of-use')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('LegalPage')
                ->where('page.title', 'Terms of Use')
                ->where('page.path', '/terms-of-use')
                ->where('page.last_updated', '30 September 2026')
                ->where('page.last_updated_iso', '2026-09-30')
                ->has('page.sections', 13)
                ->where('page.sections.0.id', 'about-us')
                ->where('page.sections.0.heading', 'About us'));
    }

    public function test_privacy_policy_page_renders_seeded_content(): void
    {
        $this->get('/privacy-policy')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('LegalPage')
                ->where('page.title', 'Privacy Policy')
                ->where('page.path', '/privacy-policy')
                ->has('page.sections', 13)
                ->where('page.sections.0.id', 'who-we-are'));
    }

    public function test_missing_legal_page_returns_404_instead_of_falling_through_to_contact_cards(): void
    {
        LegalPage::query()->where('slug', LegalPage::PRIVACY_POLICY)->delete();

        $this->get('/privacy-policy')->assertNotFound();
    }

    public function test_rich_text_is_sanitised_before_rendering(): void
    {
        LegalPage::query()->where('slug', LegalPage::TERMS_OF_USE)->firstOrFail()->update([
            'intro' => '<p onclick="alert(1)">Intro</p><script>alert(1)</script>',
            'sections' => [[
                'heading' => 'Links',
                'body' => '<p>Read <a href="javascript:alert(1)">this</a> and <a href="/privacy-policy">our policy</a>.</p><img src="x" onerror="alert(1)">',
            ]],
        ]);

        $this->get('/terms-of-use')->assertInertia(function (Assert $page): void {
            $intro = $page->toArray()['props']['page']['intro'];
            $body = $page->toArray()['props']['page']['sections'][0]['body'];

            $this->assertSame('<p>Intro</p>', $intro);
            $this->assertStringNotContainsString('javascript:', $body);
            $this->assertStringNotContainsString('onerror', $body);
            $this->assertStringContainsString('<a href="/privacy-policy">our policy</a>', $body);
        });
    }

    public function test_section_anchor_ids_are_unique_and_blank_headings_are_skipped(): void
    {
        LegalPage::query()->where('slug', LegalPage::TERMS_OF_USE)->firstOrFail()->update([
            'sections' => [
                ['heading' => 'Contact us', 'body' => '<p>One</p>'],
                ['heading' => '   ', 'body' => '<p>Orphan</p>'],
                ['heading' => 'Contact us', 'body' => '<p>Two</p>'],
                ['heading' => '!!!', 'body' => '<p>Three</p>'],
            ],
        ]);

        $this->get('/terms-of-use')->assertInertia(fn (Assert $page) => $page
            ->has('page.sections', 3)
            ->where('page.sections.0.id', 'contact-us')
            ->where('page.sections.1.id', 'contact-us-2')
            ->where('page.sections.2.id', 'section-3'));
    }

    public function test_admin_sees_both_pages_but_cannot_create_new_ones(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $this->get(LegalPageResource::getUrl('index'))
            ->assertOk()
            ->assertSee('Terms of Use')
            ->assertSee('Privacy Policy');

        $this->assertFalse(LegalPageResource::canCreate());
        $this->get('/admin/legal-pages/create')->assertNotFound();
    }

    public function test_non_admin_cannot_open_legal_pages_admin(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => false]));

        $this->get(LegalPageResource::getUrl('index'))->assertForbidden();
    }

    public function test_admin_can_edit_a_legal_page(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $page = LegalPage::query()->where('slug', LegalPage::PRIVACY_POLICY)->firstOrFail();
        $undoRepeaterFake = Repeater::fake();

        Livewire::test(EditLegalPage::class, ['record' => $page->getRouteKey()])
            ->fillForm([
                'title' => 'Privacy Notice',
                'last_updated_at' => '2026-10-15',
                'sections' => [
                    ['heading' => 'Who we are', 'body' => '<p>Updated company details.</p>'],
                    ['heading' => 'Your rights', 'body' => '<p>Updated rights.</p>'],
                ],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $undoRepeaterFake();

        $page->refresh();

        $this->assertSame('Privacy Notice', $page->title);
        $this->assertSame('2026-10-15', $page->last_updated_at->toDateString());
        $this->assertSame(['Who we are', 'Your rights'], array_column($page->sections, 'heading'));
        $this->assertStringContainsString('Updated rights.', $page->sections[1]['body']);
        $this->assertSame(LegalPage::PRIVACY_POLICY, $page->slug);
    }

    public function test_section_heading_is_required(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $page = LegalPage::query()->where('slug', LegalPage::PRIVACY_POLICY)->firstOrFail();
        $undoRepeaterFake = Repeater::fake();

        Livewire::test(EditLegalPage::class, ['record' => $page->getRouteKey()])
            ->fillForm([
                'sections' => [
                    ['heading' => '', 'body' => '<p>No heading.</p>'],
                ],
            ])
            ->call('save')
            ->assertHasFormErrors(['sections.0.heading' => 'required']);

        $undoRepeaterFake();
    }
}
