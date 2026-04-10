<?php

namespace App\Livewire\Admin\Portfolio;

use App\Enums\ProjectLifecycleStatus;
use App\Enums\PublicationStatus;
use App\Models\PortfolioProject;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Title('Projects')]
class ProjectsManager extends Component
{
    use WithFileUploads;
    use WithPagination;

    public const int MAX_GALLERY_IMAGES = 12;

    public const int MAX_IMAGE_KB = 2048;

    public string $search = '';

    public bool $showEditor = false;

    public ?int $editingId = null;

    public string $title = '';

    public string $slug = '';

    public string $eyebrow = '';

    public string $headline = '';

    public string $summary = '';

    public string $full_description = '';

    public string $result = '';

    public string $metric = '';

    public string $year = '';

    public string $client = '';

    public string $challenge = '';

    public string $approach = '';

    public string $icon = 'apps-24';

    public string $stack_csv = '';

    public string $impact_csv = '';

    public string $deliverables_csv = '';

    public string $publication_status = 'published';

    public string $project_status = 'completed';

    public int $sort_order = 0;

    public bool $is_featured = false;

    public string $live_url = '';

    public string $github_url = '';

    public string $seo_title = '';

    public string $seo_description = '';

    public bool $clearOgImage = false;

    public ?string $existingOgImageUrl = null;

    public $ogImage = null;

    /** @var array<int, mixed> */
    public array $galleryUploads = [];

    /**
     * Stored public disk paths for gallery (edited in form).
     *
     * @var array<int, string>
     */
    public array $galleryPaths = [];

    public bool $clearThumbnail = false;

    public ?string $existingThumbnailUrl = null;

    public $thumbnail = null;

    public function mount(): void
    {
        $this->authorize('viewAny', PortfolioProject::class);
    }

    public function openCreate(): void
    {
        $this->authorize('create', PortfolioProject::class);
        $this->editingId = null;
        $this->resetForm();
        $this->showEditor = true;
    }

    public function openEdit(int $id): void
    {
        $project = PortfolioProject::query()->findOrFail($id);
        $this->authorize('update', $project);
        $this->editingId = $id;
        $this->title = $project->title;
        $this->slug = $project->slug;
        $this->eyebrow = (string) ($project->eyebrow ?? '');
        $this->headline = (string) ($project->headline ?? '');
        $this->summary = $project->summary;
        $this->full_description = (string) ($project->full_description ?? '');
        $this->result = (string) ($project->result ?? '');
        $this->metric = (string) ($project->metric ?? '');
        $this->year = (string) ($project->year ?? '');
        $this->client = (string) ($project->client ?? '');
        $this->challenge = (string) ($project->challenge ?? '');
        $this->approach = (string) ($project->approach ?? '');
        $this->icon = $project->icon;
        $this->stack_csv = implode(', ', $project->stack ?? []);
        $this->impact_csv = implode("\n", $project->impact_points ?? []);
        $this->deliverables_csv = implode("\n", $project->deliverables ?? []);
        $this->publication_status = $project->publication_status instanceof PublicationStatus
            ? $project->publication_status->value
            : (string) $project->publication_status;
        $this->project_status = $project->project_status instanceof ProjectLifecycleStatus
            ? $project->project_status->value
            : (string) $project->project_status;
        $this->sort_order = $project->sort_order;
        $this->is_featured = $project->is_featured;
        $this->live_url = (string) ($project->live_url ?? '');
        $this->github_url = (string) ($project->github_url ?? '');
        $this->seo_title = (string) ($project->seo_title ?? '');
        $this->seo_description = (string) ($project->seo_description ?? '');
        $this->galleryPaths = array_values(array_filter($project->gallery_paths ?? []));
        $this->existingThumbnailUrl = $project->thumbnailPublicUrl();
        $this->clearThumbnail = false;
        $this->thumbnail = null;
        $this->galleryUploads = [];
        $this->existingOgImageUrl = $project->ogImagePublicUrl();
        $this->clearOgImage = false;
        $this->ogImage = null;
        $this->showEditor = true;
    }

    public function closeEditor(): void
    {
        $this->showEditor = false;
        $this->editingId = null;
        $this->resetForm();
    }

    public function removeThumbnail(): void
    {
        $this->thumbnail = null;
        $this->clearThumbnail = true;
    }

    public function removeOgImage(): void
    {
        $this->ogImage = null;
        $this->clearOgImage = true;
    }

    public function removeGalleryImage(int $index): void
    {
        if (! isset($this->galleryPaths[$index])) {
            return;
        }

        $path = $this->galleryPaths[$index];
        Storage::disk('public')->delete($path);
        unset($this->galleryPaths[$index]);
        $this->galleryPaths = array_values($this->galleryPaths);
        Flux::toast(variant: 'success', text: __('Gallery image removed.'));
    }

    public function save(): void
    {
        $maxNew = max(0, self::MAX_GALLERY_IMAGES - count($this->galleryPaths));

        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'summary' => ['required', 'string'],
            'full_description' => ['nullable', 'string', 'max:20000'],
            'publication_status' => ['required', 'in:draft,published'],
            'project_status' => ['required', 'in:draft,in_progress,completed,archived'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65000'],
            'live_url' => ['nullable', 'string', 'max:500'],
            'github_url' => ['nullable', 'string', 'max:500'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:512'],
            'thumbnail' => ['nullable', 'image', 'max:'.self::MAX_IMAGE_KB],
            'ogImage' => ['nullable', 'image', 'max:'.self::MAX_IMAGE_KB],
            'galleryUploads' => ['nullable', 'array', 'max:'.$maxNew],
            'galleryUploads.*' => ['image', 'max:'.self::MAX_IMAGE_KB],
        ];

        $this->validate($rules);

        if ($this->live_url !== '' && ! filter_var($this->live_url, FILTER_VALIDATE_URL)) {
            $this->addError('live_url', __('Enter a valid URL.'));

            return;
        }

        if ($this->github_url !== '' && ! filter_var($this->github_url, FILTER_VALIDATE_URL)) {
            $this->addError('github_url', __('Enter a valid URL.'));

            return;
        }

        $slug = $this->slug !== '' ? Str::slug($this->slug) : Str::slug($this->title);
        $slug = $this->ensureUniqueSlug($slug);

        $previous = $this->editingId
            ? PortfolioProject::query()->find($this->editingId)
            : null;

        $thumbnailPath = $previous?->thumbnail_path;

        if ($this->clearThumbnail) {
            if ($thumbnailPath) {
                Storage::disk('public')->delete($thumbnailPath);
            }
            $thumbnailPath = null;
        } elseif ($this->thumbnail) {
            if ($thumbnailPath) {
                Storage::disk('public')->delete($thumbnailPath);
            }
            $thumbnailPath = $this->thumbnail->store('projects/thumbnails', 'public');
        }

        $ogImagePath = $previous?->og_image_path;

        if ($this->clearOgImage) {
            if ($ogImagePath) {
                Storage::disk('public')->delete($ogImagePath);
            }
            $ogImagePath = null;
        } elseif ($this->ogImage) {
            if ($ogImagePath) {
                Storage::disk('public')->delete($ogImagePath);
            }
            $ogImagePath = $this->ogImage->store('projects/og', 'public');
        }

        $galleryPaths = $this->galleryPaths;
        foreach ($this->galleryUploads as $file) {
            if (count($galleryPaths) >= self::MAX_GALLERY_IMAGES) {
                break;
            }
            if (is_object($file) && method_exists($file, 'store')) {
                $galleryPaths[] = $file->store('projects/gallery', 'public');
            }
        }
        $galleryPaths = array_values(array_filter($galleryPaths));

        $payload = [
            'title' => $this->title,
            'slug' => $slug,
            'eyebrow' => $this->eyebrow ?: null,
            'headline' => $this->headline ?: null,
            'summary' => $this->summary,
            'full_description' => $this->full_description !== '' ? $this->full_description : null,
            'result' => $this->result ?: null,
            'metric' => $this->metric ?: null,
            'year' => $this->year ?: null,
            'client' => $this->client ?: null,
            'challenge' => $this->challenge ?: null,
            'approach' => $this->approach ?: null,
            'icon' => $this->icon ?: 'apps-24',
            'stack' => $this->splitCommaList($this->stack_csv),
            'impact_points' => $this->splitLines($this->impact_csv),
            'deliverables' => $this->splitLines($this->deliverables_csv),
            'publication_status' => PublicationStatus::from($this->publication_status),
            'project_status' => ProjectLifecycleStatus::from($this->project_status),
            'sort_order' => $this->sort_order,
            'is_featured' => $this->is_featured,
            'thumbnail_path' => $thumbnailPath,
            'gallery_paths' => $galleryPaths,
            'live_url' => $this->live_url !== '' ? $this->live_url : null,
            'github_url' => $this->github_url !== '' ? $this->github_url : null,
            'seo_title' => $this->seo_title !== '' ? $this->seo_title : null,
            'seo_description' => $this->seo_description !== '' ? $this->seo_description : null,
            'og_image_path' => $ogImagePath,
        ];

        if ($this->publication_status === PublicationStatus::Published->value) {
            $payload['published_at'] = now();
        } else {
            $payload['published_at'] = null;
        }

        if ($this->editingId) {
            $project = PortfolioProject::query()->findOrFail($this->editingId);
            $this->authorize('update', $project);
            $project->update($payload);
            Flux::toast(variant: 'success', text: __('Project updated.'));
        } else {
            $this->authorize('create', PortfolioProject::class);
            PortfolioProject::query()->create($payload);
            Flux::toast(variant: 'success', text: __('Project created.'));
        }

        $this->closeEditor();
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $project = PortfolioProject::query()->findOrFail($id);
        $this->authorize('delete', $project);
        $project->delete();
        Flux::toast(variant: 'success', text: __('Project moved to trash.'));
        $this->resetPage();
    }

    public function render()
    {
        $projects = PortfolioProject::query()
            ->when($this->search !== '', function ($q): void {
                $q->where(function ($q): void {
                    $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('slug', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(12);

        return view('livewire.admin.portfolio.projects-manager', [
            'projects' => $projects,
        ]);
    }

    private function resetForm(): void
    {
        $this->title = '';
        $this->slug = '';
        $this->eyebrow = '';
        $this->headline = '';
        $this->summary = '';
        $this->full_description = '';
        $this->result = '';
        $this->metric = '';
        $this->year = '';
        $this->client = '';
        $this->challenge = '';
        $this->approach = '';
        $this->icon = 'apps-24';
        $this->stack_csv = '';
        $this->impact_csv = '';
        $this->deliverables_csv = '';
        $this->publication_status = PublicationStatus::Published->value;
        $this->project_status = ProjectLifecycleStatus::Completed->value;
        $this->sort_order = 0;
        $this->is_featured = false;
        $this->live_url = '';
        $this->github_url = '';
        $this->seo_title = '';
        $this->seo_description = '';
        $this->galleryPaths = [];
        $this->galleryUploads = [];
        $this->thumbnail = null;
        $this->clearThumbnail = false;
        $this->existingThumbnailUrl = null;
        $this->ogImage = null;
        $this->clearOgImage = false;
        $this->existingOgImageUrl = null;
    }

    /**
     * @return array<int, string>
     */
    private function splitCommaList(string $value): array
    {
        if (trim($value) === '') {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $value))));
    }

    /**
     * @return array<int, string>
     */
    private function splitLines(string $value): array
    {
        if (trim($value) === '') {
            return [];
        }

        $lines = preg_split('/\r\n|\r|\n/', $value) ?: [];

        return array_values(array_filter(array_map('trim', $lines)));
    }

    private function ensureUniqueSlug(string $slug): string
    {
        $base = $slug;
        $i = 2;
        while (
            PortfolioProject::query()
                ->where('slug', $slug)
                ->when($this->editingId, fn ($q) => $q->where('id', '!=', $this->editingId))
                ->exists()
        ) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
