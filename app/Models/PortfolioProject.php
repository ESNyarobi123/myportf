<?php

namespace App\Models;

use App\Enums\ProjectLifecycleStatus;
use App\Enums\PublicationStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Fillable([
    'title',
    'slug',
    'eyebrow',
    'headline',
    'summary',
    'result',
    'metric',
    'icon',
    'year',
    'client',
    'challenge',
    'approach',
    'impact_points',
    'deliverables',
    'stack',
    'full_description',
    'category',
    'project_status',
    'publication_status',
    'is_featured',
    'sort_order',
    'thumbnail_path',
    'gallery_paths',
    'live_url',
    'github_url',
    'completed_at',
    'seo_title',
    'seo_description',
    'og_image_path',
    'published_at',
    'scheduled_publish_at',
])]
class PortfolioProject extends Model
{
    /** @use HasFactory<\Database\Factories\PortfolioProjectFactory> */
    use HasFactory, SoftDeletes;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'impact_points' => 'array',
            'deliverables' => 'array',
            'stack' => 'array',
            'gallery_paths' => 'array',
            'is_featured' => 'boolean',
            'completed_at' => 'date',
            'published_at' => 'datetime',
            'scheduled_publish_at' => 'datetime',
            'project_status' => ProjectLifecycleStatus::class,
            'publication_status' => PublicationStatus::class,
        ];
    }

    /**
     * @param  Builder<PortfolioProject>  $query
     * @return Builder<PortfolioProject>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('publication_status', PublicationStatus::Published)
            ->where(function (Builder $q): void {
                $q->whereNull('scheduled_publish_at')
                    ->orWhere('scheduled_publish_at', '<=', now());
            });
    }

    /**
     * @return array<string, mixed>
     */
    public function toViewArray(?string $fallbackShareImageAbsoluteUrl = null): array
    {
        $galleryPaths = array_values(array_filter($this->gallery_paths ?? []));

        $shareImageUrl = $this->absolutePublicUrl($this->ogImagePublicUrl() ?? $this->thumbnailPublicUrl());
        if ($shareImageUrl === null && $fallbackShareImageAbsoluteUrl !== null && $fallbackShareImageAbsoluteUrl !== '') {
            $shareImageUrl = $fallbackShareImageAbsoluteUrl;
        }

        return [
            'slug' => $this->slug,
            'eyebrow' => $this->eyebrow ?? '',
            'title' => $this->title,
            'headline' => $this->headline ?? '',
            'summary' => $this->summary,
            'result' => $this->result ?? '',
            'metric' => $this->metric ?? '',
            'icon' => $this->icon,
            'year' => $this->year ?? '',
            'client' => $this->client ?? '',
            'challenge' => $this->challenge ?? '',
            'approach' => $this->approach ?? '',
            'impact_points' => $this->impact_points ?? [],
            'deliverables' => $this->deliverables ?? [],
            'stack' => $this->stack ?? [],
            'thumbnail_url' => $this->thumbnailPublicUrl(),
            'gallery_urls' => array_values(array_filter(array_map(
                fn (string $path): ?string => $this->publicStorageUrl($path),
                $galleryPaths,
            ))),
            'live_url' => $this->live_url,
            'github_url' => $this->github_url,
            'full_description' => $this->full_description,
            'page_title' => $this->pageTitleForMeta(),
            'meta_description' => $this->metaDescriptionForPublic(),
            'canonical_url' => route('projects.show', $this->slug),
            'share_image_url' => $shareImageUrl,
        ];
    }

    public function pageTitleForMeta(): string
    {
        $seo = trim((string) ($this->seo_title ?? ''));

        return $seo !== '' ? $seo : $this->title;
    }

    public function metaDescriptionForPublic(): string
    {
        $seo = trim((string) ($this->seo_description ?? ''));
        $source = $seo !== '' ? $seo : (string) $this->summary;

        return Str::limit(strip_tags($source), 160, preserveWords: true);
    }

    public function thumbnailPublicUrl(): ?string
    {
        if ($this->thumbnail_path === null || $this->thumbnail_path === '') {
            return null;
        }

        return $this->publicStorageUrl($this->thumbnail_path);
    }

    private function publicStorageUrl(string $path): ?string
    {
        $path = ltrim($path, '/');
        if ($path === '') {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    public function ogImagePublicUrl(): ?string
    {
        if ($this->og_image_path === null || $this->og_image_path === '') {
            return null;
        }

        return $this->publicStorageUrl($this->og_image_path);
    }

    private function absolutePublicUrl(?string $pathOrUrl): ?string
    {
        if ($pathOrUrl === null || trim($pathOrUrl) === '') {
            return null;
        }

        $trimmed = trim($pathOrUrl);

        if (preg_match('#^https?://#i', $trimmed) === 1) {
            return $trimmed;
        }

        return url($trimmed);
    }

    protected static function booted(): void
    {
        self::creating(function (PortfolioProject $project): void {
            if ($project->slug === null || $project->slug === '') {
                $project->slug = Str::slug((string) $project->title);
            }
            if ($project->publication_status === PublicationStatus::Published && $project->published_at === null) {
                $project->published_at = now();
            }
        });

        self::updating(function (PortfolioProject $project): void {
            if ($project->isDirty('publication_status')
                && $project->publication_status === PublicationStatus::Published
                && $project->published_at === null) {
                $project->published_at = now();
            }
        });

        self::forceDeleting(function (PortfolioProject $project): void {
            if ($project->thumbnail_path) {
                Storage::disk('public')->delete($project->thumbnail_path);
            }
            if ($project->og_image_path) {
                Storage::disk('public')->delete($project->og_image_path);
            }
            foreach ($project->gallery_paths ?? [] as $path) {
                if (is_string($path) && $path !== '') {
                    Storage::disk('public')->delete($path);
                }
            }
        });
    }
}
