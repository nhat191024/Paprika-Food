@props(['title', 'description'])

<div class="py-20 text-center bg-zinc-50 dark:bg-zinc-900 rounded-3xl border border-zinc-200 dark:border-zinc-800">
    <h1 class="text-5xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h1>
    <p class="mt-4 text-xl text-zinc-600 dark:text-zinc-400">{{ $description }}</p>
    <div class="mt-8">
        {{ $slot }}
    </div>
</div>