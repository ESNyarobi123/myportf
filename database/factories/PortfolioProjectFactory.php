<?php

namespace Database\Factories;

use App\Enums\ProjectLifecycleStatus;
use App\Enums\PublicationStatus;
use App\Models\PortfolioProject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PortfolioProject>
 */
class PortfolioProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('###'),
            'eyebrow' => 'Case study',
            'headline' => fake()->sentence(8),
            'summary' => fake()->paragraph(),
            'result' => fake()->sentence(),
            'metric' => 'Shipped',
            'icon' => 'apps-24',
            'year' => (string) fake()->year(),
            'client' => fake()->company(),
            'challenge' => fake()->paragraph(),
            'approach' => fake()->paragraph(),
            'impact_points' => [fake()->sentence(), fake()->sentence()],
            'deliverables' => [fake()->word(), fake()->word()],
            'stack' => ['Laravel', 'Livewire'],
            'project_status' => ProjectLifecycleStatus::Completed,
            'publication_status' => PublicationStatus::Draft,
            'is_featured' => false,
            'sort_order' => 0,
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes): array => [
            'publication_status' => PublicationStatus::Published,
            'published_at' => now(),
            'scheduled_publish_at' => null,
        ]);
    }
}
