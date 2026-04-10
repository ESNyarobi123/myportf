<?php

namespace App\Models;

use App\Enums\PublicationStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'author_name',
    'author_role',
    'company',
    'quote',
    'avatar_path',
    'is_featured',
    'sort_order',
    'publication_status',
    'published_at',
])]
class PortfolioTestimonial extends Model
{
    /** @use HasFactory<\Database\Factories\PortfolioTestimonialFactory> */
    use HasFactory, SoftDeletes;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
            'publication_status' => PublicationStatus::class,
        ];
    }
}
