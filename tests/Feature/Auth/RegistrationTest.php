<?php

use Laravel\Fortify\Features;

test('registration is disabled', function () {
    expect(Features::enabled(Features::registration()))->toBeFalse();

    $response = $this->get('/register');

    $response->assertNotFound();
});
