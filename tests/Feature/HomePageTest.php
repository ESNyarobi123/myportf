<?php

test('home page showcases the public portfolio sections', function () {
    $response = $this->get(route('home'));

    $response
        ->assertOk()
        ->assertSee('full-stack web apps')
        ->assertSee('Featured projects')
        ->assertSee('Services')
        ->assertSee('About My Work')
        ->assertSee('Read case study')
        ->assertSee('Ops Control Center');
});
