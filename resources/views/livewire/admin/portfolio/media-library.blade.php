@php
    use Illuminate\Support\Facades\Storage;
@endphp

<section class="flex h-full w-full flex-1 flex-col gap-6 p-4 sm:p-6">
    <div>
        <h1 class="font-display text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">{{ __('Media library') }}</h1>
        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Upload once, reuse paths in projects and site profile (copy URL from the table).') }}</p>
    </div>

    <div class="dev-card-flat max-w-xl rounded-2xl border border-zinc-200/90 p-6 dark:border-zinc-700/90">
        <flux:heading size="sm" class="mb-3">{{ __('Upload') }}</flux:heading>
        <form wire:submit="saveUploads" class="flex flex-col gap-4">
            <input type="file" wire:model="uploads" multiple class="text-sm text-zinc-600 file:mr-4 file:rounded-lg file:border-0 file:bg-terra file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white" />
            <flux:error name="uploads" />
            <flux:button type="submit" variant="primary">{{ __('Upload files') }}</flux:button>
        </form>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-zinc-200/90 dark:border-zinc-700/90">
        <table class="min-w-full divide-y divide-zinc-200 text-left text-sm dark:divide-zinc-800">
            <thead class="bg-zinc-50/80 text-xs font-medium uppercase tracking-wider text-zinc-500 dark:bg-zinc-900/60">
                <tr>
                    <th class="px-4 py-3">{{ __('Preview') }}</th>
                    <th class="px-4 py-3">{{ __('Path / URL') }}</th>
                    <th class="px-4 py-3">{{ __('Size') }}</th>
                    <th class="px-4 py-3 text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse ($assets as $asset)
                    <tr wire:key="media-{{ $asset->id }}">
                        <td class="px-4 py-3">
                            @if ($asset->mime && str_starts_with($asset->mime, 'image/'))
                                <img src="{{ Storage::disk($asset->disk)->url($asset->path) }}" alt="" class="h-12 w-12 rounded object-cover" />
                            @else
                                <span class="font-mono text-xs text-zinc-500">{{ $asset->mime }}</span>
                            @endif
                        </td>
                        <td class="max-w-md px-4 py-3 font-mono text-xs break-all text-zinc-600 dark:text-zinc-400">
                            {{ Storage::disk($asset->disk)->url($asset->path) }}
                        </td>
                        <td class="px-4 py-3 text-xs text-zinc-500">{{ $asset->size ? number_format($asset->size / 1024, 1).' KB' : '—' }}</td>
                        <td class="px-4 py-3 text-end">
                            <flux:button size="sm" variant="danger" wire:click="delete({{ $asset->id }})" wire:confirm="{{ __('Delete file?') }}">
                                {{ __('Delete') }}
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-sm text-zinc-500">{{ __('No files yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex justify-end">{{ $assets->links() }}</div>
</section>
