<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('portfolio.contact-form')
        ->assertStatus(200);
});
