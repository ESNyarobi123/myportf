<?php

namespace App\Livewire\Admin\Portfolio;

use App\Models\PortfolioProfile;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Site profile')]
class SiteProfileManager extends Component
{
    use WithFileUploads;

    public const int MAX_OG_IMAGE_KB = 2048;
    public string $brand_name = '';

    public string $nickname = '';

    public string $role_title = '';

    public string $hero_stack_pill = '';

    public string $headline = '';

    public string $summary = '';

    public string $positioning = '';

    public string $bio = '';

    public ?int $years_experience = null;

    public string $metrics_json = '';

    public string $contact_channels_json = '';

    public string $availability_json = '';

    public string $stack_json = '';

    public string $site_seo_title = '';

    public string $site_seo_description = '';

    public bool $clearDefaultOgImage = false;

    public ?string $existingDefaultOgImageUrl = null;

    public $defaultOgImage = null;

    public function mount(): void
    {
        $this->authorize('viewAny', PortfolioProfile::class);

        $profile = PortfolioProfile::query()->first();

        if ($profile === null) {
            $this->metrics_json = "[]\n";
            $this->contact_channels_json = "[]\n";
            $this->availability_json = "[]\n";
            $this->stack_json = "[]\n";
            $this->existingDefaultOgImageUrl = null;
            $this->clearDefaultOgImage = false;
            $this->defaultOgImage = null;

            return;
        }

        $this->brand_name = (string) ($profile->brand_name ?? '');
        $this->nickname = (string) ($profile->nickname ?? '');
        $this->role_title = (string) ($profile->role_title ?? '');
        $this->hero_stack_pill = (string) ($profile->hero_stack_pill ?? '');
        $this->headline = (string) ($profile->headline ?? '');
        $this->summary = (string) ($profile->summary ?? '');
        $this->positioning = (string) ($profile->positioning ?? '');
        $this->bio = (string) ($profile->bio ?? '');
        $this->years_experience = $profile->years_experience;
        $this->metrics_json = json_encode($profile->metrics ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $this->contact_channels_json = json_encode($profile->contact_channels ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $this->availability_json = json_encode($profile->availability ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $this->stack_json = json_encode($profile->stack ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $this->site_seo_title = (string) ($profile->site_seo_title ?? '');
        $this->site_seo_description = (string) ($profile->site_seo_description ?? '');
        $this->existingDefaultOgImageUrl = $profile->defaultOgImagePublicUrl();
        $this->clearDefaultOgImage = false;
        $this->defaultOgImage = null;
    }

    public function removeDefaultOgImage(): void
    {
        $this->defaultOgImage = null;
        $this->clearDefaultOgImage = true;
    }

    public function save(): void
    {
        $this->authorize('viewAny', PortfolioProfile::class);

        $this->validate([
            'brand_name' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:5000'],
            'metrics_json' => ['nullable', 'string'],
            'contact_channels_json' => ['nullable', 'string'],
            'availability_json' => ['nullable', 'string'],
            'stack_json' => ['nullable', 'string'],
            'defaultOgImage' => ['nullable', 'image', 'max:'.self::MAX_OG_IMAGE_KB],
        ]);

        $metrics = $this->decodeJsonField($this->metrics_json, 'metrics_json');
        $contactChannels = $this->decodeJsonField($this->contact_channels_json, 'contact_channels_json');
        $availability = $this->decodeJsonField($this->availability_json, 'availability_json');
        $stack = $this->decodeJsonField($this->stack_json, 'stack_json');

        $previous = PortfolioProfile::query()->first();
        $ogPath = $previous?->default_og_image_path;

        if ($this->clearDefaultOgImage) {
            if ($ogPath !== null && $ogPath !== '') {
                Storage::disk('public')->delete($ogPath);
            }
            $ogPath = null;
        } elseif ($this->defaultOgImage) {
            if ($ogPath !== null && $ogPath !== '') {
                Storage::disk('public')->delete($ogPath);
            }
            $ogPath = $this->defaultOgImage->store('site/og', 'public');
        }

        PortfolioProfile::query()->updateOrCreate(
            ['id' => 1],
            [
                'brand_name' => $this->brand_name ?: null,
                'nickname' => $this->nickname ?: null,
                'role_title' => $this->role_title ?: null,
                'hero_stack_pill' => $this->hero_stack_pill ?: null,
                'headline' => $this->headline ?: null,
                'summary' => $this->summary ?: null,
                'positioning' => $this->positioning ?: null,
                'bio' => $this->bio ?: null,
                'years_experience' => $this->years_experience,
                'metrics' => $metrics,
                'contact_channels' => $contactChannels,
                'availability' => $availability,
                'stack' => $stack,
                'site_seo_title' => $this->site_seo_title ?: null,
                'site_seo_description' => $this->site_seo_description ?: null,
                'default_og_image_path' => $ogPath,
            ],
        );

        $this->defaultOgImage = null;
        $this->clearDefaultOgImage = false;
        $this->existingDefaultOgImageUrl = PortfolioProfile::query()->first()?->defaultOgImagePublicUrl();

        Flux::toast(variant: 'success', text: __('Site profile saved.'));
    }

    public function render()
    {
        return view('livewire.admin.portfolio.site-profile-manager');
    }

    /**
     * @return array<mixed>|null
     */
    private function decodeJsonField(string $raw, string $errorKey): ?array
    {
        $raw = trim($raw);
        if ($raw === '') {
            return null;
        }

        try {
            $decoded = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            throw ValidationException::withMessages([
                $errorKey => __('Invalid JSON in this block.'),
            ]);
        }

        return is_array($decoded) ? $decoded : null;
    }
}
