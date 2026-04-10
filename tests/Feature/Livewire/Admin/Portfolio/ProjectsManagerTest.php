<?php

use App\Livewire\Admin\Portfolio\ProjectsManager;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::actingAs(User::factory()->create())
        ->test(ProjectsManager::class)
        ->assertOk();
});
