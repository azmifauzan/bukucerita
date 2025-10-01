<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="index, follow">
        <meta name="author" content="Buku Cerita">
        <meta name="generator" content="Laravel {{ app()->version() }}">
        
        <!-- Default SEO Meta Tags -->
        <meta name="description" content="Buku Cerita - Platform cerita anak digital Indonesia terlengkap. Temukan ribuan cerita interaktif untuk anak-anak dengan teknologi AI Google Gemini.">
        <meta name="keywords" content="buku cerita anak, cerita anak indonesia, buku digital anak, cerita interaktif, dongeng anak, bacaan anak, AI cerita, Google Gemini">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ request()->url() }}">
        <meta property="og:title" content="{{ config('app.name', 'BukuCerita') }}">
        <meta property="og:description" content="Platform cerita anak digital Indonesia terlengkap. Temukan ribuan cerita interaktif untuk anak-anak dengan teknologi AI.">
        @if(file_exists(public_path('images/og-image.jpg')))
        <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
        @endif
        <meta property="og:site_name" content="Buku Cerita">
        <meta property="og:locale" content="id_ID">
        
        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ request()->url() }}">
        <meta name="twitter:title" content="{{ config('app.name', 'BukuCerita') }}">
        <meta name="twitter:description" content="Platform cerita anak digital Indonesia terlengkap. Temukan ribuan cerita interaktif untuk anak-anak.">
        @if(file_exists(public_path('images/twitter-image.jpg')))
        <meta name="twitter:image" content="{{ asset('images/twitter-image.jpg') }}">
        @endif
        
        <!-- Canonical URL -->
        <link rel="canonical" href="{{ request()->url() }}">
        
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        @if(file_exists(public_path('apple-touch-icon.png')))
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        @endif
        
        <title inertia>{{ config('app.name', 'BukuCerita') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
