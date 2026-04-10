<?php

dataset('portfolio pages', [
    'projects' => ['projects', 'Case studies'],
    'services' => ['services', 'What I build'],
    'about' => ['about', 'About me'],
    'contact' => ['contact', "Let's work together."],
]);

dataset('project case studies', [
    'ops control center' => ['ops-control-center', 'What needed to change'],
    'service marketplace' => ['service-marketplace', 'How the product was shaped'],
    'growth insight hub' => ['growth-insight-hub', 'Other projects'],
]);

test('portfolio pages can be rendered', function (string $routeName, string $headline) {
    $response = $this->get(route($routeName));

    $response
        ->assertOk()
        ->assertSee($headline, escape: false);
})->with('portfolio pages');

test('project case studies can be rendered', function (string $slug, string $content) {
    $response = $this->get(route('projects.show', $slug));

    $response
        ->assertOk()
        ->assertSee($content);
})->with('project case studies');

test('missing project case study returns a 404 response', function () {
    $response = $this->get(route('projects.show', 'missing-project'));

    $response->assertNotFound();
});
