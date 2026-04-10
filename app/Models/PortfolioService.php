<?php

namespace App\Models;

use App\Enums\PublicationStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'title',
    'short_intro',
    'full_details',
    'icon',
    'cover_image_path',
    'pricing_note',
    'cta_label',
    'cta_url',
    'sort_order',
    'is_active',
    'publication_status',
    'published_at',
])]
class PortfolioService extends Model
{
    /** @use HasFactory<\Database\Factories\PortfolioServiceFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'published_at' => 'datetime',
            'publication_status' => PublicationStatus::class,
        ];
    }

    /**
     * @param  Builder<PortfolioService>  $query
     * @return Builder<PortfolioService>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where('publication_status', PublicationStatus::Published)
            ->where(function (Builder $q): void {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    /**
     * @return array<string, mixed>
     */
    public function toViewArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->short_intro ?? '',
            'icon' => $this->icon,
        ];
    }
}
