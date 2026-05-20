@props([
    'type' => 'radio',
    'name',
    'value',
    'label',
    'description' => null,
    'priceAdjustment' => 0,
    'checked' => false,
])

<label class="flex cursor-pointer items-center justify-between gap-4 rounded-xl border border-zinc-200 p-4 transition-colors hover:border-amber-500 dark:border-zinc-700 dark:hover:border-amber-500">
    <div class="flex items-center gap-3">
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            value="{{ $value }}"
            @checked($checked)
            {{ $attributes->class([
                'h-5 w-5 cursor-pointer border-zinc-300 text-amber-500 focus:ring-amber-500 dark:border-zinc-600 dark:bg-zinc-800',
                'rounded' => $type === 'checkbox',
            ]) }}
        >

        <span class="flex flex-col">
            <span class="font-medium text-zinc-900 dark:text-white">{{ $label }}</span>

            @if($description)
                <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ $description }}</span>
            @endif
        </span>
    </div>

    @if((float) $priceAdjustment > 0)
        <span class="shrink-0 font-medium text-zinc-500">+{{ number_format((float) $priceAdjustment, 2) }} &euro;</span>
    @endif
</label>
