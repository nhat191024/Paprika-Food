@if($product->variants->isNotEmpty())
    <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <div class="mb-4 flex items-center justify-between gap-4">
            <flux:heading size="lg">{{ __('client/details.variants') }}</flux:heading>
            <span class="rounded bg-amber-50 px-2 py-1 text-xs font-bold uppercase tracking-wider text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                {{ __('client/details.required') }}
            </span>
        </div>

        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            @foreach($product->variants as $variant)
                <x-details.choice-option
                    type="radio"
                    name="variant_id"
                    :value="$variant->id"
                    :label="$variant->name"
                    :price-adjustment="$variant->price_adjustment"
                    :checked="$loop->first"
                    x-on:change="selectedVariantId = {{ $variant->id }}; variantExtra = Number({{ (float) $variant->price_adjustment }})"
                />
            @endforeach
        </div>
    </div>
@endif
