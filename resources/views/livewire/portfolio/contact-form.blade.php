<div class="dev-card-flat p-8">
    <p class="font-mono text-[10px] uppercase tracking-widest text-terra">{{ __('Send a message') }}</p>
    <h2 class="mt-2 font-display text-2xl text-zinc-950 dark:text-white">{{ __('Project inquiry') }}</h2>
    <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Share a short brief — I usually reply quickly.') }}</p>

    <form wire:submit="submit" class="mt-6 flex flex-col gap-4">
        <flux:input wire:model="name" :label="__('Name')" required autocomplete="name" />
        <flux:input wire:model="email" type="email" :label="__('Email')" required autocomplete="email" />
        <flux:input wire:model="phone" :label="__('Phone (optional)')" autocomplete="tel" />
        <flux:textarea wire:model="body" :label="__('Message')" rows="5" required />
        <flux:button type="submit" variant="primary" class="w-full sm:w-auto">{{ __('Send message') }}</flux:button>
    </form>
</div>
