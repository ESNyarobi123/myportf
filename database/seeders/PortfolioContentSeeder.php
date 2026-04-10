<?php

namespace Database\Seeders;

use App\Enums\ProjectLifecycleStatus;
use App\Enums\PublicationStatus;
use App\Models\PortfolioProfile;
use App\Models\PortfolioProject;
use App\Models\PortfolioService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortfolioContentSeeder extends Seeder
{
    /**
     * Seed portfolio profile, projects, and services from config/portfolio.php (structured defaults).
     */
    public function run(): void
    {
        /** @var array<string, mixed> $config */
        $config = config('portfolio', []);

        DB::transaction(function () use ($config): void {
            $brand = $config['brand'] ?? [];

            PortfolioProfile::query()->updateOrCreate(
                ['id' => 1],
                [
                    'brand_name' => $brand['name'] ?? null,
                    'nickname' => $brand['nickname'] ?? null,
                    'role_title' => $brand['role'] ?? null,
                    'hero_stack_pill' => $brand['hero_stack_pill'] ?? null,
                    'headline' => $brand['headline'] ?? null,
                    'summary' => $brand['summary'] ?? null,
                    'positioning' => $brand['positioning'] ?? null,
                    'hero_focus' => $brand['hero_focus'] ?? null,
                    'metrics' => $config['metrics'] ?? null,
                    'preview_cards' => $config['preview_cards'] ?? null,
                    'archive_projects' => $config['archive_projects'] ?? null,
                    'capabilities' => $config['capabilities'] ?? null,
                    'workflow' => $config['workflow'] ?? null,
                    'proof_points' => $config['proof_points'] ?? null,
                    'about_highlights' => $config['about_highlights'] ?? null,
                    'contact_channels' => $config['contact_channels'] ?? null,
                    'availability' => $config['availability'] ?? null,
                    'stack' => $config['stack'] ?? null,
                ],
            );

            foreach ($config['projects'] ?? [] as $index => $project) {
                if (! is_array($project)) {
                    continue;
                }

                PortfolioProject::query()->updateOrCreate(
                    ['slug' => (string) ($project['slug'] ?? '')],
                    [
                        'title' => (string) ($project['title'] ?? 'Untitled'),
                        'eyebrow' => $project['eyebrow'] ?? null,
                        'headline' => $project['headline'] ?? null,
                        'summary' => (string) ($project['summary'] ?? ''),
                        'result' => $project['result'] ?? null,
                        'metric' => $project['metric'] ?? null,
                        'icon' => $project['icon'] ?? 'apps-24',
                        'year' => $project['year'] ?? null,
                        'client' => $project['client'] ?? null,
                        'challenge' => $project['challenge'] ?? null,
                        'approach' => $project['approach'] ?? null,
                        'impact_points' => $project['impact_points'] ?? [],
                        'deliverables' => $project['deliverables'] ?? [],
                        'stack' => $project['stack'] ?? [],
                        'full_description' => null,
                        'category' => $project['eyebrow'] ?? null,
                        'project_status' => ProjectLifecycleStatus::Completed,
                        'publication_status' => PublicationStatus::Published,
                        'is_featured' => $index === 0,
                        'sort_order' => $index,
                        'published_at' => now(),
                    ],
                );
            }

            foreach ($config['services'] ?? [] as $index => $service) {
                if (! is_array($service)) {
                    continue;
                }

                PortfolioService::query()->updateOrCreate(
                    ['title' => (string) ($service['title'] ?? 'Service')],
                    [
                        'short_intro' => $service['description'] ?? null,
                        'full_details' => null,
                        'icon' => $service['icon'] ?? 'globe-24',
                        'sort_order' => $index,
                        'is_active' => true,
                        'publication_status' => PublicationStatus::Published,
                        'published_at' => now(),
                    ],
                );
            }
        });
    }
}
