<section class="flex h-full w-full flex-1 flex-col gap-6 p-4 sm:p-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">{{ __('Inquiries') }}</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Messages from the public contact form.') }}</p>
        </div>
        <flux:input wire:model.live.debounce.300ms="search" :placeholder="__('Search')" class="min-w-[14rem]" />
    </div>

    <div class="overflow-x-auto rounded-2xl border border-zinc-200/90 dark:border-zinc-700/90">
        <table class="min-w-full divide-y divide-zinc-200 text-left text-sm dark:divide-zinc-800">
            <thead class="bg-zinc-50/80 text-xs font-medium uppercase tracking-wider text-zinc-500 dark:bg-zinc-900/60">
                <tr>
                    <th class="px-4 py-3">{{ __('Date') }}</th>
                    <th class="px-4 py-3">{{ __('From') }}</th>
                    <th class="px-4 py-3">{{ __('Preview') }}</th>
                    <th class="px-4 py-3">{{ __('Status') }}</th>
                    <th class="px-4 py-3 text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse ($inquiries as $inquiry)
                    <tr wire:key="inq-{{ $inquiry->id }}">
                        <td class="px-4 py-3 font-mono text-xs text-zinc-500">{{ $inquiry->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-3">
                            <p class="font-medium text-zinc-900 dark:text-zinc-100">{{ $inquiry->name }}</p>
                            <p class="text-xs text-zinc-500">{{ $inquiry->email }}</p>
                        </td>
                        <td class="max-w-md px-4 py-3 text-zinc-600 dark:text-zinc-400">{{ \Illuminate\Support\Str::limit($inquiry->body, 120) }}</td>
                        <td class="px-4 py-3">
                            <flux:badge size="sm" color="{{ $inquiry->status->value === 'new' ? 'amber' : 'zinc' }}">
                                {{ $inquiry->status->value }}
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3 text-end">
                            <flux:button size="sm" variant="ghost" wire:click="markRead({{ $inquiry->id }})">{{ __('Read') }}</flux:button>
                            <flux:button size="sm" variant="ghost" wire:click="archive({{ $inquiry->id }})">{{ __('Archive') }}</flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-sm text-zinc-500">{{ __('No inquiries yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex justify-end">{{ $inquiries->links() }}</div>
</section>
