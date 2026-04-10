<?php

namespace App\Models;

use App\Enums\PublicationStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'title',
    'company',
    'location',
    'started_on',
    'ended_on',
    'is_current',
    'summary',
    'stack_tags',
    'sort_order',
    'publication_status',
])]
class PortfolioExperienceEntry extends Model
{
    /** @use HasFactory<\Database\Factories\PortfolioExperienceEntryFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'started_on' => 'date',
            'ended_on' => 'date',
            'is_current' => 'boolean',
            'stack_tags' => 'array',
            'publication_status' => PublicationStatus::class,
        ];
    }
}
