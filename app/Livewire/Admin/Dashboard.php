<?php

namespace App\Livewire\Admin;

use App\Enums\PublicationStatus;
use App\Models\ContactInquiry;
use App\Models\MediaAsset;
use App\Models\PortfolioProject;
use App\Models\PortfolioService;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        $publishedMissingThumbnail = PortfolioProject::query()
            ->published()
            ->where(function (Builder $query): void {
                $query->whereNull('thumbnail_path')->orWhere('thumbnail_path', '');
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get(['id', 'title']);

        return view('livewire.admin.dashboard', [
            'projectCount' => PortfolioProject::query()->count(),
            'serviceCount' => PortfolioService::query()->count(),
            'inquiryCount' => ContactInquiry::query()->count(),
            'mediaCount' => MediaAsset::query()->count(),
            'draftProjectCount' => PortfolioProject::query()
                ->where('publication_status', PublicationStatus::Draft)
                ->count(),
            'publishedMissingThumbnailCount' => $publishedMissingThumbnail->count(),
            'publishedMissingThumbnailTitles' => $publishedMissingThumbnail->take(4),
            'recentInquiries' => ContactInquiry::query()
                ->latest()
                ->limit(6)
                ->get(['id', 'name', 'email', 'created_at', 'status']),
        ]);
    }
}
