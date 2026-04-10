<?php

namespace App\Portfolio;

use App\Models\PortfolioProfile;
use App\Models\PortfolioProject;
use App\Models\PortfolioService;

final class PortfolioPresentation
{
    /**
     * Build the public portfolio payload (same shape as config/portfolio.php) from DB with config fallback.
     *
     * @return array<string, mixed>
     */
    public static function snapshot(): array
    {
        $defaults = config('portfolio', []);

        $profile = PortfolioProfile::query()->first();

        if ($profile === null) {
            return $defaults;
        }

        $defaultOgImageUrl = $profile->defaultOgImageAbsoluteUrl();

        return [
            'brand' => self::brand($profile, $defaults),
            'metrics' => $profile->metrics ?? data_get($defaults, 'metrics', []),
            'preview_cards' => $profile->preview_cards ?? data_get($defaults, 'preview_cards', []),
            'default_og_image_url' => $defaultOgImageUrl,
            'projects' => self::projects($defaults, $defaultOgImageUrl),
            'archive_projects' => $profile->archive_projects ?? data_get($defaults, 'archive_projects', []),
            'capabilities' => $profile->capabilities ?? data_get($defaults, 'capabilities', []),
            'services' => self::services($defaults),
            'workflow' => $profile->workflow ?? data_get($defaults, 'workflow', []),
            'proof_points' => $profile->proof_points ?? data_get($defaults, 'proof_points', []),
            'about_highlights' => $profile->about_highlights ?? data_get($defaults, 'about_highlights', []),
            'contact_channels' => $profile->contact_channels ?? data_get($defaults, 'contact_channels', []),
            'availability' => $profile->availability ?? data_get($defaults, 'availability', []),
            'stack' => $profile->stack ?? data_get($defaults, 'stack', []),
        ];
    }

    /**
     * @param  array<string, mixed>  $defaults
     * @return array<string, mixed>
     */
    private static function brand(PortfolioProfile $profile, array $defaults): array
    {
        $base = data_get($defaults, 'brand', []);

        $availabilityLine = data_get($profile->availability, 'headline');

        $overrides = collect([
            'name' => $profile->brand_name,
            'nickname' => $profile->nickname,
            'role' => $profile->role_title,
            'hero_stack_pill' => $profile->hero_stack_pill,
            'headline' => $profile->headline,
            'summary' => $profile->summary,
            'positioning' => $profile->positioning,
            'availability' => $availabilityLine ?? data_get($base, 'availability'),
            'hero_focus' => $profile->hero_focus,
        ])->reject(fn (mixed $v): bool => $v === null || $v === '' || (is_array($v) && $v === []))->all();

        return array_merge($base, $overrides);
    }

    /**
     * @param  array<string, mixed>  $defaults
     * @return array<int, array<string, mixed>>
     */
    private static function projects(array $defaults, ?string $defaultShareImageAbsoluteUrl = null): array
    {
        $rows = PortfolioProject::query()
            ->published()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        if ($rows->isEmpty()) {
            /** @var array<int, array<string, mixed>> */
            return data_get($defaults, 'projects', []);
        }

        return $rows->map(fn (PortfolioProject $project): array => $project->toViewArray($defaultShareImageAbsoluteUrl))->all();
    }

    /**
     * @param  array<string, mixed>  $defaults
     * @return array<int, array<string, mixed>>
     */
    private static function services(array $defaults): array
    {
        $rows = PortfolioService::query()
            ->published()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        if ($rows->isEmpty()) {
            /** @var array<int, array<string, mixed>> */
            return data_get($defaults, 'services', []);
        }

        return $rows->map(fn (PortfolioService $service): array => $service->toViewArray())->all();
    }
}
