@php
    $effectiveMinSelect = $group->is_required ? max(1, (int) $group->min_select) : 0;
    $effectiveMaxSelect = max(1, (int) $group->max_select);
    $isRequiredSingleChoice = $group->is_required && $effectiveMinSelect === 1 && $effectiveMaxSelect === 1;
    $defaultItemIds = $group->items
        ->filter(fn ($item): bool => $item->product !== null || $item->variant !== null)
        ->take(min($effectiveMinSelect, $effectiveMaxSelect))
        ->pluck('id');

    $selectionLabel = match (true) {
        $effectiveMinSelect === 1 && $effectiveMaxSelect === 1 && $group->is_required => __('client/details.choose_one'),
        $effectiveMinSelect === 0 && $effectiveMaxSelect === 1 => __('client/details.choose_up_to_one'),
        $effectiveMinSelect === $effectiveMaxSelect => __('client/details.choose_exactly', ['count' => $effectiveMinSelect]),
        $effectiveMinSelect === 0 => __('client/details.choose_up_to', ['max' => $effectiveMaxSelect]),
        default => __('client/details.selection_range', ['min' => $effectiveMinSelect, 'max' => $effectiveMaxSelect]),
    };
@endphp

<div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
    <div class="mb-4 flex items-center justify-between gap-4">
        <flux:heading size="lg">{{ $group->name }}</flux:heading>

        @if($group->is_required)
            <span class="rounded bg-red-50 px-2 py-1 text-xs font-bold uppercase tracking-wider text-red-600 dark:bg-red-500/10 dark:text-red-400">
                {{ __('client/details.required') }}
            </span>
        @else
            <span class="text-xs text-zinc-500">{{ __('client/details.optional') }}</span>
        @endif
    </div>

    <p class="mb-4 text-sm text-zinc-500 dark:text-zinc-400">
        {{ $selectionLabel }}
    </p>

    <div class="{{ $effectiveMaxSelect == 1 && $group->items->count() <= 4 ? 'grid grid-cols-1 gap-3 sm:grid-cols-2' : 'space-y-3' }}">
        @foreach($group->items as $item)
            @php
                $itemModel = $item->product ?? $item->variant;
                $label = $item->product?->name ?? $item->variant?->name;
                $description = $item->variant?->product?->name;
                $isOptionalSingleChoice = ! $group->is_required && $effectiveMaxSelect === 1;
                $inputType = $isRequiredSingleChoice ? 'radio' : 'checkbox';
                $inputName = 'group_' . $group->id . ($inputType === 'checkbox' ? '[]' : '');
                $checked = $group->is_required && $defaultItemIds->contains($item->id);
                $shouldEnforceMax = $inputType === 'checkbox' && ! $isOptionalSingleChoice;
            @endphp

            @if($itemModel)
                <x-details.choice-option
                    :type="$inputType"
                    :name="$inputName"
                    :value="$item->id"
                    :label="$label"
                    :description="$description"
                    :price-adjustment="$item->extra_price"
                    :checked="$checked"
                    x-bind:disabled="{{ $shouldEnforceMax ? 'true' : 'false' }} && ! $el.checked && selectedComboCount({{ $group->id }}) >= {{ $effectiveMaxSelect }}"
                    x-on:change="
                        if ({{ $isOptionalSingleChoice ? 'true' : 'false' }} && $event.target.checked) {
                            document.querySelectorAll('input[name=&quot;{{ $inputName }}&quot;]').forEach((input) => {
                                if (input !== $event.target) {
                                    input.checked = false;
                                }
                            });
                        }

                        if ({{ $shouldEnforceMax ? 'true' : 'false' }} && $event.target.checked && selectedComboCount({{ $group->id }}) >= {{ $effectiveMaxSelect }}) {
                            $event.target.checked = false;
                            return;
                        }

                        setComboExtra({{ $group->id }}, {{ $item->id }}, {{ (float) $item->extra_price }}, $event.target.checked, {{ $isOptionalSingleChoice ? 1 : $effectiveMaxSelect }});
                    "
                />
            @endif
        @endforeach
    </div>
</div>
