<?php

use App\Livewire\Admin\Portfolio\InquiriesManager;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::actingAs(User::factory()->create())
        ->test(InquiriesManager::class)
        ->assertOk();
});
