<?php

use App\Enums\PublicationStatus;
use App\Models\ContactInquiry;
use App\Models\PortfolioProject;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test('admin.dashboard')
        ->assertStatus(200);
});

it('shows recent inquiries and content hints', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    ContactInquiry::factory()->create([
        'name' => 'Dashboard Inquiry Client',
        'email' => 'client@example.test',
    ]);

    PortfolioProject::factory()->create([
        'title' => 'Draft Alpha',
        'publication_status' => PublicationStatus::Draft,
    ]);

    PortfolioProject::factory()
        ->published()
        ->create([
            'title' => 'Live Without Thumb',
            'thumbnail_path' => null,
        ]);

    Livewire::test('admin.dashboard')
        ->assertSee('Dashboard Inquiry Client', false)
        ->assertSee('client@example.test', false)
        ->assertSee('Needs attention', false)
        ->assertSee('1 draft project needs publishing.', false)
        ->assertSee('Live Without Thumb', false);
});
