@props(['flat' => false])

@php
$availableLocales = collect(\Illuminate\Support\Facades\File::directories(lang_path()))
    ->map(fn (string $directory): string => basename($directory))
    ->reject(fn (string $locale): bool => $locale === 'vendor')
    ->sort()
    ->values();

$localeLabels = [
    'el' => 'Greek',
    'en' => 'English',
    'vi' => 'Tiếng Việt',
];
@endphp

@if ($flat)
    @foreach ($availableLocales as $locale)
        <form method="POST" action="{{ route('locale.update') }}" class="w-full">
            @csrf
            <input type="hidden" name="locale" value="{{ $locale }}">
            <flux:menu.item
                as="button"
                type="submit"
                class="w-full cursor-pointer"
                :icon="app()->getLocale() === $locale ? 'check' : null"
            >
                {{ $localeLabels[$locale] ?? strtoupper($locale) }}
            </flux:menu.item>
        </form>
    @endforeach
@else
    <flux:menu.submenu :heading="__('common/language.switch')" icon="language">
        @foreach ($availableLocales as $locale)
            <form method="POST" action="{{ route('locale.update') }}" class="w-full">
                @csrf
                <input type="hidden" name="locale" value="{{ $locale }}">
                <flux:menu.item
                    as="button"
                    type="submit"
                    class="w-full cursor-pointer"
                    :icon="app()->getLocale() === $locale ? 'check' : null"
                >
                    {{ $localeLabels[$locale] ?? strtoupper($locale) }}
                </flux:menu.item>
            </form>
        @endforeach
    </flux:menu.submenu>
@endif
