<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'brand_name',
    'nickname',
    'role_title',
    'hero_stack_pill',
    'headline',
    'summary',
    'positioning',
    'hero_focus',
    'metrics',
    'preview_cards',
    'archive_projects',
    'capabilities',
    'workflow',
    'proof_points',
    'about_highlights',
    'contact_channels',
    'availability',
    'stack',
    'years_experience',
    'bio',
    'profile_image_path',
    'stats',
    'skills',
    'education',
    'certifications',
    'achievements',
    'site_seo_title',
    'site_seo_description',
    'default_og_image_path',
])]
class PortfolioProfile extends Model
{
    /** @use HasFactory<\Database\Factories\PortfolioProfileFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'hero_focus' => 'array',
            'metrics' => 'array',
            'preview_cards' => 'array',
            'archive_projects' => 'array',
            'capabilities' => 'array',
            'workflow' => 'array',
            'proof_points' => 'array',
            'about_highlights' => 'array',
            'contact_channels' => 'array',
            'availability' => 'array',
            'stack' => 'array',
            'stats' => 'array',
            'skills' => 'array',
            'education' => 'array',
            'certifications' => 'array',
            'achievements' => 'array',
            'years_experience' => 'integer',
        ];
    }

    public function defaultOgImagePublicUrl(): ?string
    {
        if ($this->default_og_image_path === null || $this->default_og_image_path === '') {
            return null;
        }

        $path = ltrim((string) $this->default_og_image_path, '/');
        if ($path === '') {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    public function defaultOgImageAbsoluteUrl(): ?string
    {
        $relativeOrUrl = $this->defaultOgImagePublicUrl();
        if ($relativeOrUrl === null || trim($relativeOrUrl) === '') {
            return null;
        }

        $trimmed = trim($relativeOrUrl);
        if (preg_match('#^https?://#i', $trimmed) === 1) {
            return $trimmed;
        }

        return url($trimmed);
    }
}
