<section class="flex h-full w-full flex-1 flex-col gap-6 p-4 sm:p-6">
    <div>
        <h1 class="font-display text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">{{ __('Site profile') }}</h1>
        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Brand copy and structured JSON blocks — same shape as config/portfolio.php, stored in the database.') }}
        </p>
    </div>

    <form wire:submit="save" class="flex max-w-4xl flex-col gap-6">
        <div class="grid gap-4 sm:grid-cols-2">
            <flux:input wire:model="brand_name" :label="__('Brand name')" />
            <flux:input wire:model="nickname" :label="__('Nickname')" />
        </div>
        <flux:input wire:model="role_title" :label="__('Role title')" />
        <flux:input wire:model="hero_stack_pill" :label="__('Hero stack pill')" />
        <flux:input wire:model="headline" :label="__('Headline')" />
        <flux:textarea wire:model="summary" :label="__('Summary')" rows="4" />
        <flux:textarea wire:model="positioning" :label="__('Positioning (about)')" rows="3" />
        <flux:textarea wire:model="bio" :label="__('Bio')" rows="4" />
        <flux:input wire:model.number="years_experience" type="number" :label="__('Years experience')" />

        <div class="space-y-2">
            <flux:heading size="sm">{{ __('Metrics (JSON array)') }}</flux:heading>
            <flux:textarea wire:model="metrics_json" class="font-mono text-xs" rows="8" />
            <flux:error name="metrics_json" />
        </div>
        <div class="space-y-2">
            <flux:heading size="sm">{{ __('Contact channels (JSON)') }}</flux:heading>
            <flux:textarea wire:model="contact_channels_json" class="font-mono text-xs" rows="10" />
            <flux:error name="contact_channels_json" />
        </div>
        <div class="space-y-2">
            <flux:heading size="sm">{{ __('Availability block (JSON)') }}</flux:heading>
            <flux:textarea wire:model="availability_json" class="font-mono text-xs" rows="8" />
            <flux:error name="availability_json" />
        </div>
        <div class="space-y-2">
            <flux:heading size="sm">{{ __('Stack tags (JSON array of strings)') }}</flux:heading>
            <flux:textarea wire:model="stack_json" class="font-mono text-xs" rows="6" />
            <flux:error name="stack_json" />
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <flux:input wire:model="site_seo_title" :label="__('Site SEO title')" />
            <flux:input wire:model="site_seo_description" :label="__('Site SEO description')" />
        </div>

        <div class="rounded-xl border border-zinc-200/90 p-4 dark:border-zinc-700/90">
            <flux:heading size="sm" class="mb-2">{{ __('Default social image') }}</flux:heading>
            <p class="mb-3 text-xs text-zinc-500">
                {{ __('Used when a project has no thumbnail or social preview image (Open Graph / Twitter).') }}
            </p>
            @if ($defaultOgImage)
                <div class="mb-3">
                    <img src="{{ $defaultOgImage->temporaryUrl() }}" alt="" class="max-h-40 rounded-lg border border-zinc-200 object-cover dark:border-zinc-700" />
                </div>
            @elseif ($existingDefaultOgImageUrl && ! $clearDefaultOgImage)
                <div class="mb-3 flex items-start gap-3">
                    <img src="{{ $existingDefaultOgImageUrl }}" alt="" class="max-h-40 rounded-lg border border-zinc-200 object-cover dark:border-zinc-700" />
                    <flux:button type="button" size="sm" variant="ghost" wire:click="removeDefaultOgImage">{{ __('Remove') }}</flux:button>
                </div>
            @endif
            <input
                type="file"
                wire:model="defaultOgImage"
                accept="image/jpeg,image/png,image/webp,image/gif"
                class="block w-full text-sm text-zinc-600 file:mr-4 file:rounded-lg file:border-0 file:bg-terra file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white"
            />
            <flux:error name="defaultOgImage" />
        </div>

        <div>
            <flux:button type="submit" variant="primary">{{ __('Save site profile') }}</flux:button>
        </div>
    </form>
</section>
