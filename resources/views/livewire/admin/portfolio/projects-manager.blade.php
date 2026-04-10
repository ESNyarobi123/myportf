@php
    use Illuminate\Support\Facades\Storage;
@endphp

<section class="flex h-full w-full flex-1 flex-col gap-6 p-4 sm:p-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">{{ __('Projects') }}</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Thumbnails & gallery (max 2MB each) — shown on the public projects grid and case study page.') }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <flux:input wire:model.live.debounce.300ms="search" :placeholder="__('Search title or slug')" class="min-w-[12rem]" />
            <flux:button variant="primary" wire:click="openCreate">{{ __('New project') }}</flux:button>
        </div>
    </div>

    <flux:modal wire:model.self="showEditor" class="max-h-[90vh] max-w-4xl overflow-y-auto">
        <form wire:submit="save" class="flex flex-col gap-4 p-2">
            <flux:heading size="lg">{{ $editingId ? __('Edit project') : __('New project') }}</flux:heading>

            <div class="grid gap-4 sm:grid-cols-2">
                <flux:input wire:model="title" :label="__('Title')" required />
                <flux:input wire:model="slug" :label="__('Slug (optional)')" placeholder="auto-from-title" />
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <flux:input wire:model="eyebrow" :label="__('Eyebrow')" />
                <flux:input wire:model="headline" :label="__('Headline')" />
            </div>
            <flux:textarea wire:model="summary" :label="__('Summary')" rows="3" required />
            <flux:textarea wire:model="full_description" :label="__('Full description (optional, case study)')" rows="5" />

            <div class="rounded-xl border border-zinc-200/90 p-4 dark:border-zinc-700/90">
                <flux:heading size="sm" class="mb-2">{{ __('Thumbnail (card image)') }}</flux:heading>
                <p class="mb-3 text-xs text-zinc-500">{{ __('JPG, PNG, WebP — up to 2MB. Recommended wide ratio (e.g. 1200×630).') }}</p>
                @if ($thumbnail)
                    <div class="mb-3">
                        <img src="{{ $thumbnail->temporaryUrl() }}" alt="" class="max-h-40 rounded-lg border border-zinc-200 object-cover dark:border-zinc-700" />
                    </div>
                @elseif ($existingThumbnailUrl && ! $clearThumbnail)
                    <div class="mb-3 flex items-start gap-3">
                        <img src="{{ $existingThumbnailUrl }}" alt="" class="max-h-40 rounded-lg border border-zinc-200 object-cover dark:border-zinc-700" />
                        <flux:button type="button" size="sm" variant="ghost" wire:click="removeThumbnail">{{ __('Remove') }}</flux:button>
                    </div>
                @endif
                <input type="file" wire:model="thumbnail" accept="image/jpeg,image/png,image/webp,image/gif" class="block w-full text-sm text-zinc-600 file:mr-4 file:rounded-lg file:border-0 file:bg-terra file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white" />
                <flux:error name="thumbnail" />
            </div>

            <div class="rounded-xl border border-zinc-200/90 p-4 dark:border-zinc-700/90">
                <flux:heading size="sm" class="mb-2">{{ __('Gallery (case study)') }}</flux:heading>
                <p class="mb-3 text-xs text-zinc-500">{{ __('Up to 12 images, 2MB each.') }}</p>
                @if (count($galleryPaths) > 0)
                    <div class="mb-3 flex flex-wrap gap-2">
                        @foreach ($galleryPaths as $idx => $gPath)
                            <div class="relative inline-block" wire:key="gal-{{ $idx }}-{{ $gPath }}">
                                <img src="{{ Storage::disk('public')->url($gPath) }}" alt="" class="h-20 w-28 rounded-lg border border-zinc-200 object-cover dark:border-zinc-700" />
                                <flux:button type="button" size="sm" variant="danger" class="mt-1 w-full text-[10px]" wire:click="removeGalleryImage({{ (int) $idx }})">{{ __('Remove') }}</flux:button>
                            </div>
                        @endforeach
                    </div>
                @endif
                <input
                    type="file"
                    wire:model="galleryUploads"
                    multiple
                    accept="image/jpeg,image/png,image/webp,image/gif"
                    class="block w-full text-sm text-zinc-600 file:mr-4 file:rounded-lg file:border-0 file:bg-zinc-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white"
                />
                <flux:error name="galleryUploads" />
                <flux:error name="galleryUploads.*" />
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <flux:input wire:model="live_url" :label="__('Live site URL')" type="url" placeholder="https://..." />
                <flux:input wire:model="github_url" :label="__('GitHub URL')" type="url" placeholder="https://github.com/..." />
            </div>

            <div class="rounded-xl border border-zinc-200/90 p-4 dark:border-zinc-700/90">
                <flux:heading size="sm" class="mb-2">{{ __('SEO & sharing') }}</flux:heading>
                <p class="mb-3 text-xs text-zinc-500">{{ __('Optional. Open Graph image defaults to the project thumbnail when empty.') }}</p>
                <div class="grid gap-4 sm:grid-cols-2">
                    <flux:input wire:model="seo_title" :label="__('SEO title')" :placeholder="__('Overrides browser tab title')" />
                    <flux:input wire:model="seo_description" :label="__('SEO description')" :placeholder="__('Search & social preview text')" />
                </div>
                <div class="mt-4">
                    <p class="mb-2 text-xs font-medium text-zinc-600 dark:text-zinc-300">{{ __('Social preview image (optional)') }}</p>
                    @if ($ogImage)
                        <div class="mb-3">
                            <img src="{{ $ogImage->temporaryUrl() }}" alt="" class="max-h-40 rounded-lg border border-zinc-200 object-cover dark:border-zinc-700" />
                        </div>
                    @elseif ($existingOgImageUrl && ! $clearOgImage)
                        <div class="mb-3 flex items-start gap-3">
                            <img src="{{ $existingOgImageUrl }}" alt="" class="max-h-40 rounded-lg border border-zinc-200 object-cover dark:border-zinc-700" />
                            <flux:button type="button" size="sm" variant="ghost" wire:click="removeOgImage">{{ __('Remove') }}</flux:button>
                        </div>
                    @endif
                    <input type="file" wire:model="ogImage" accept="image/jpeg,image/png,image/webp,image/gif" class="block w-full text-sm text-zinc-600 file:mr-4 file:rounded-lg file:border-0 file:bg-zinc-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white" />
                    <flux:error name="ogImage" />
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <flux:input wire:model="year" :label="__('Year')" />
                <flux:input wire:model="client" :label="__('Client')" />
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <flux:textarea wire:model="challenge" :label="__('Challenge')" rows="3" />
                <flux:textarea wire:model="approach" :label="__('Approach')" rows="3" />
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <flux:input wire:model="result" :label="__('Result line')" />
                <flux:input wire:model="metric" :label="__('Metric / outcome')" />
            </div>
            <flux:input wire:model="icon" :label="__('Fluent icon name')" description="e.g. apps-24" />
            <flux:textarea wire:model="stack_csv" :label="__('Tech stack (comma-separated)')" rows="2" />
            <flux:textarea wire:model="impact_csv" :label="__('Impact points (one per line)')" rows="3" />
            <flux:textarea wire:model="deliverables_csv" :label="__('Deliverables (one per line)')" rows="3" />
            <div class="grid gap-4 sm:grid-cols-2">
                <flux:select wire:model="publication_status" :label="__('Publication')">
                    <flux:select.option value="draft">{{ __('Draft') }}</flux:select.option>
                    <flux:select.option value="published">{{ __('Published') }}</flux:select.option>
                </flux:select>
                <flux:select wire:model="project_status" :label="__('Project status')">
                    <flux:select.option value="draft">{{ __('Draft') }}</flux:select.option>
                    <flux:select.option value="in_progress">{{ __('In progress') }}</flux:select.option>
                    <flux:select.option value="completed">{{ __('Completed') }}</flux:select.option>
                    <flux:select.option value="archived">{{ __('Archived') }}</flux:select.option>
                </flux:select>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <flux:input wire:model.number="sort_order" type="number" :label="__('Sort order')" />
                <flux:switch wire:model="is_featured" :label="__('Featured')" />
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <flux:button type="button" variant="ghost" wire:click="closeEditor">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
            </div>
        </form>
    </flux:modal>

    <div class="overflow-x-auto rounded-2xl border border-zinc-200/90 dark:border-zinc-700/90">
        <table class="min-w-full divide-y divide-zinc-200 text-left text-sm dark:divide-zinc-800">
            <thead class="bg-zinc-50/80 text-xs font-medium uppercase tracking-wider text-zinc-500 dark:bg-zinc-900/60">
                <tr>
                    <th class="px-4 py-3">{{ __('Thumb') }}</th>
                    <th class="px-4 py-3">{{ __('Order') }}</th>
                    <th class="px-4 py-3">{{ __('Title') }}</th>
                    <th class="px-4 py-3">{{ __('Slug') }}</th>
                    <th class="px-4 py-3">{{ __('Status') }}</th>
                    <th class="px-4 py-3 text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse ($projects as $project)
                    <tr wire:key="project-{{ $project->id }}" class="bg-white/40 dark:bg-zinc-950/20">
                        <td class="px-4 py-2">
                            @if ($project->thumbnailPublicUrl())
                                <img src="{{ $project->thumbnailPublicUrl() }}" alt="" class="size-10 rounded-lg border border-zinc-200 object-cover dark:border-zinc-700" width="40" height="40" />
                            @else
                                <span class="flex size-10 items-center justify-center rounded-lg border border-dashed border-zinc-300 text-[10px] text-zinc-400 dark:border-zinc-600">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-mono text-xs text-zinc-500">{{ $project->sort_order }}</td>
                        <td class="px-4 py-3 font-medium text-zinc-900 dark:text-zinc-100">{{ $project->title }}</td>
                        <td class="px-4 py-3 font-mono text-xs text-zinc-500">{{ $project->slug }}</td>
                        <td class="px-4 py-3">
                            <flux:badge size="sm" color="{{ $project->publication_status->value === 'published' ? 'green' : 'zinc' }}">
                                {{ $project->publication_status->value }}
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3 text-end">
                            @if ($project->publication_status === \App\Enums\PublicationStatus::Published)
                                <flux:button size="sm" variant="ghost" :href="route('projects.show', $project->slug)" target="_blank">{{ __('View') }}</flux:button>
                            @endif
                            <flux:button size="sm" variant="ghost" wire:click="openEdit({{ $project->id }})">{{ __('Edit') }}</flux:button>
                            <flux:button size="sm" variant="danger" wire:click="delete({{ $project->id }})" wire:confirm="{{ __('Delete this project?') }}">
                                {{ __('Delete') }}
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-sm text-zinc-500">{{ __('No projects yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex justify-end">
        {{ $projects->links() }}
    </div>
</section>
