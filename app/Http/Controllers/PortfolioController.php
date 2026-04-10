<?php

namespace App\Http\Controllers;

use App\Portfolio\PortfolioPresentation;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class PortfolioController extends Controller
{
    public function showProject(string $project): View
    {
        $projects = $this->projects();

        /** @var array<string, mixed>|null $selectedProject */
        $selectedProject = $projects->firstWhere('slug', $project);

        abort_if($selectedProject === null, 404);

        $relatedProjects = $projects
            ->reject(fn (array $portfolioProject): bool => $portfolioProject['slug'] === $project)
            ->values()
            ->all();

        return view('portfolio.project', [
            'project' => $selectedProject,
            'relatedProjects' => array_slice($relatedProjects, 0, 2),
            'projectJsonLd' => $this->projectJsonLd($selectedProject),
        ]);
    }

    /**
     * @param  array<string, mixed>  $project
     * @return array<string, mixed>
     */
    private function projectJsonLd(array $project): array
    {
        $payload = [
            '@context' => 'https://schema.org',
            '@type' => 'CreativeWork',
            'name' => (string) ($project['page_title'] ?? $project['title'] ?? ''),
            'headline' => (string) ($project['headline'] ?? ''),
            'description' => (string) ($project['meta_description'] ?? ''),
            'url' => (string) ($project['canonical_url'] ?? ''),
        ];

        if (! empty($project['share_image_url'])) {
            $payload['image'] = $project['share_image_url'];
        }

        return $payload;
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    private function projects(): Collection
    {
        /** @var array<int, array<string, mixed>> $projects */
        $projects = PortfolioPresentation::snapshot()['projects'] ?? [];

        return collect($projects);
    }
}
