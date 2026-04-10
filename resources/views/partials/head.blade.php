@php
    $applicationName = config('portfolio.brand.name', config('app.name', 'ERICKsky'));
@endphp

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.$applicationName : $applicationName }}
</title>

<meta name="theme-color" content="#282427">

<link rel="icon" href="{{ asset('logo.jpeg') }}" type="image/jpeg" sizes="any">
<link rel="apple-touch-icon" href="{{ asset('logo.jpeg') }}">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=fraunces:500,600,700|instrument-sans:400,500,600,700" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
