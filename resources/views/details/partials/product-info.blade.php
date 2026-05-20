<div>
    <flux:heading size="xl" class="mb-4 font-black text-4xl text-zinc-900 dark:text-white">{{ $product->name }}</flux:heading>
    <flux:text class="mb-6 text-lg text-zinc-600 dark:text-zinc-400">{{ $product->description }}</flux:text>
    <div class="text-3xl font-bold text-amber-600 dark:text-amber-500" x-text="formatPrice(unitPrice())"></div>
</div>
