<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

<meta name="description" content="{{ $description ?? 'Food delivery and management app' }}">
<meta name="theme-color" content="#FF2D20">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ filled($title ?? null) ? $title.' - '.config('app.name') : config('app.name') }}">
<meta property="og:description" content="{{ $description ?? 'Food delivery and management app' }}">
<meta property="og:image" content="{{ asset('apple-touch-icon-180x180.png') }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="{{ filled($title ?? null) ? $title.' - '.config('app.name') : config('app.name') }}">
<meta property="twitter:description" content="{{ $description ?? 'Food delivery and management app' }}">
<meta property="twitter:image" content="{{ asset('apple-touch-icon-180x180.png') }}">

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon-180x180.png">
<link rel="manifest" href="/manifest.webmanifest">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
<script>
    if (!window.localStorage.getItem('flux.appearance')) {
        window.localStorage.setItem('flux.appearance', 'light');
    }
</script>
@fluxAppearance
