<?php

namespace App\Livewire\Admin\Portfolio;

use App\Enums\PublicationStatus;
use App\Models\PortfolioService;
use Flux\Flux;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Services')]
class ServicesManager extends Component
{
    use WithPagination;

    public string $search = '';

    public bool $showEditor = false;

    public ?int $editingId = null;

    public string $title = '';

    public string $short_intro = '';

    public string $full_details = '';

    public string $icon = 'globe-24';

    public string $pricing_note = '';

    public string $cta_label = '';

    public string $cta_url = '';

    public int $sort_order = 0;

    public bool $is_active = true;

    public string $publication_status = 'published';

    public function mount(): void
    {
        $this->authorize('viewAny', PortfolioService::class);
    }

    public function openCreate(): void
    {
        $this->authorize('create', PortfolioService::class);
        $this->editingId = null;
        $this->resetForm();
        $this->showEditor = true;
    }

    public function openEdit(int $id): void
    {
        $service = PortfolioService::query()->findOrFail($id);
        $this->authorize('update', $service);
        $this->editingId = $id;
        $this->title = $service->title;
        $this->short_intro = (string) ($service->short_intro ?? '');
        $this->full_details = (string) ($service->full_details ?? '');
        $this->icon = $service->icon;
        $this->pricing_note = (string) ($service->pricing_note ?? '');
        $this->cta_label = (string) ($service->cta_label ?? '');
        $this->cta_url = (string) ($service->cta_url ?? '');
        $this->sort_order = $service->sort_order;
        $this->is_active = $service->is_active;
        $this->publication_status = $service->publication_status instanceof PublicationStatus
            ? $service->publication_status->value
            : (string) $service->publication_status;
        $this->showEditor = true;
    }

    public function closeEditor(): void
    {
        $this->showEditor = false;
        $this->editingId = null;
        $this->resetForm();
    }

    public function save(): void
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'short_intro' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65000'],
            'publication_status' => ['required', 'in:draft,published'],
        ]);

        $payload = [
            'title' => $this->title,
            'short_intro' => $this->short_intro ?: null,
            'full_details' => $this->full_details ?: null,
            'icon' => $this->icon ?: 'globe-24',
            'pricing_note' => $this->pricing_note ?: null,
            'cta_label' => $this->cta_label ?: null,
            'cta_url' => $this->cta_url ?: null,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
            'publication_status' => PublicationStatus::from($this->publication_status),
        ];

        if ($this->publication_status === PublicationStatus::Published->value) {
            $payload['published_at'] = now();
        } else {
            $payload['published_at'] = null;
        }

        if ($this->editingId) {
            $service = PortfolioService::query()->findOrFail($this->editingId);
            $this->authorize('update', $service);
            $service->update($payload);
            Flux::toast(variant: 'success', text: __('Service updated.'));
        } else {
            $this->authorize('create', PortfolioService::class);
            PortfolioService::query()->create($payload);
            Flux::toast(variant: 'success', text: __('Service created.'));
        }

        $this->closeEditor();
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $service = PortfolioService::query()->findOrFail($id);
        $this->authorize('delete', $service);
        $service->delete();
        Flux::toast(variant: 'success', text: __('Service removed.'));
        $this->resetPage();
    }

    public function render()
    {
        $services = PortfolioService::query()
            ->when($this->search !== '', function ($q): void {
                $q->where('title', 'like', '%'.$this->search.'%');
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15);

        return view('livewire.admin.portfolio.services-manager', [
            'services' => $services,
        ]);
    }

    private function resetForm(): void
    {
        $this->title = '';
        $this->short_intro = '';
        $this->full_details = '';
        $this->icon = 'globe-24';
        $this->pricing_note = '';
        $this->cta_label = '';
        $this->cta_url = '';
        $this->sort_order = 0;
        $this->is_active = true;
        $this->publication_status = PublicationStatus::Published->value;
    }
}
