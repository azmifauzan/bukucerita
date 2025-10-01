User-agent: *
Allow: /

# Sitemap
Sitemap: {{ url('/sitemap.xml') }}

# Block admin areas
Disallow: /admin/
Disallow: /user/
Disallow: /dashboard
Disallow: /profile/
Disallow: /books/create
Disallow: /books/*/edit

# Block authentication pages
Disallow: /login
Disallow: /register
Disallow: /forgot-password
Disallow: /reset-password

# Allow important pages
Allow: /
Allow: /books
Allow: /books/*
Allow: /guide

# Crawl-delay (optional, helps prevent overloading)
Crawl-delay: 1