<?php

use App\Livewire\Portfolio\ContactForm;
use App\Models\ContactInquiry;
use App\Models\PortfolioProfile;
use App\Models\PortfolioProject;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('public home renders seeded project titles from the database', function (): void {
    $this->seed(DatabaseSeeder::class);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Ops Control Center', false);
});

test('guests are redirected from admin projects', function (): void {
    $this->get(route('admin.projects'))
        ->assertRedirect();
});

test('authenticated users can open the admin projects manager', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.projects'))
        ->assertOk();
});

test('contact form creates an inquiry record', function (): void {
    Livewire::test(ContactForm::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('body', 'Hello from Pest.')
        ->call('submit')
        ->assertHasNoErrors();

    expect(ContactInquiry::query()->count())->toBe(1);
});

test('project case study renders seo and open graph meta tags', function (): void {
    PortfolioProfile::factory()->create();

    PortfolioProject::factory()
        ->published()
        ->create([
            'slug' => 'seo-test-project',
            'title' => 'Display Title',
            'seo_title' => 'Custom SEO Tab Title',
            'seo_description' => 'Unique meta description for crawlers and social cards.',
        ]);

    $this->get(route('projects.show', 'seo-test-project'))
        ->assertOk()
        ->assertSee('Custom SEO Tab Title', false)
        ->assertSee('name="description"', false)
        ->assertSee('Unique meta description for crawlers', false)
        ->assertSee('rel="canonical"', false)
        ->assertSee('property="og:title"', false)
        ->assertSee('property="og:url"', false)
        ->assertSee('application/ld+json', false)
        ->assertSee('CreativeWork', false)
        ->assertSee('schema.org', false);
});

test('project case study uses site default og image when project has no thumbnail', function (): void {
    Storage::disk('public')->put('site/og/fallback.jpg', 'fake-binary');

    PortfolioProfile::factory()->create([
        'default_og_image_path' => 'site/og/fallback.jpg',
    ]);

    PortfolioProject::factory()
        ->published()
        ->create([
            'slug' => 'no-thumb-project',
            'title' => 'No Thumbnail Project',
            'thumbnail_path' => null,
            'og_image_path' => null,
        ]);

    $this->get(route('projects.show', 'no-thumb-project'))
        ->assertOk()
        ->assertSee('property="og:image"', false)
        ->assertSee('site/og/fallback.jpg', false);
});
