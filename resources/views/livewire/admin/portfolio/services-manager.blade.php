<section class="flex h-full w-full flex-1 flex-col gap-6 p-4 sm:p-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">{{ __('Services') }}</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Short intro on the public site maps to “description”; full details for expanded copy later.') }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <flux:input wire:model.live.debounce.300ms="search" :placeholder="__('Search')" class="min-w-[12rem]" />
            <flux:button variant="primary" wire:click="openCreate">{{ __('New service') }}</flux:button>
        </div>
    </div>

    <flux:modal wire:model.self="showEditor" class="max-h-[90vh] max-w-3xl overflow-y-auto">
        <form wire:submit="save" class="flex flex-col gap-4 p-2">
            <flux:heading size="lg">{{ $editingId ? __('Edit service') : __('New service') }}</flux:heading>
            <flux:input wire:model="title" :label="__('Title')" required />
            <flux:textarea wire:model="short_intro" :label="__('Short intro (public card)')" rows="3" />
            <flux:textarea wire:model="full_details" :label="__('Full details (optional)')" rows="5" />
            <flux:input wire:model="icon" :label="__('Fluent icon name')" />
            <div class="grid gap-4 sm:grid-cols-2">
                <flux:input wire:model="pricing_note" :label="__('Pricing note')" />
                <flux:input wire:model.number="sort_order" type="number" :label="__('Sort order')" />
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <flux:input wire:model="cta_label" :label="__('CTA label')" />
                <flux:input wire:model="cta_url" :label="__('CTA URL')" />
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <flux:select wire:model="publication_status" :label="__('Publication')">
                    <flux:select.option value="draft">{{ __('Draft') }}</flux:select.option>
                    <flux:select.option value="published">{{ __('Published') }}</flux:select.option>
                </flux:select>
                <flux:switch wire:model="is_active" :label="__('Active')" />
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
                    <th class="px-4 py-3">{{ __('Order') }}</th>
                    <th class="px-4 py-3">{{ __('Title') }}</th>
                    <th class="px-4 py-3">{{ __('Status') }}</th>
                    <th class="px-4 py-3">{{ __('Active') }}</th>
                    <th class="px-4 py-3 text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse ($services as $service)
                    <tr wire:key="svc-{{ $service->id }}">
                        <td class="px-4 py-3 font-mono text-xs text-zinc-500">{{ $service->sort_order }}</td>
                        <td class="px-4 py-3 font-medium text-zinc-900 dark:text-zinc-100">{{ $service->title }}</td>
                        <td class="px-4 py-3">
                            <flux:badge size="sm" color="{{ $service->publication_status->value === 'published' ? 'green' : 'zinc' }}">
                                {{ $service->publication_status->value }}
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3">{{ $service->is_active ? __('Yes') : __('No') }}</td>
                        <td class="px-4 py-3 text-end">
                            <flux:button size="sm" variant="ghost" wire:click="openEdit({{ $service->id }})">{{ __('Edit') }}</flux:button>
                            <flux:button size="sm" variant="danger" wire:click="delete({{ $service->id }})" wire:confirm="{{ __('Delete?') }}">
                                {{ __('Delete') }}
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-sm text-zinc-500">{{ __('No services yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex justify-end">{{ $services->links() }}</div>
</section>
