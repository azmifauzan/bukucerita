<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Main Pages -->
    <sitemap>
        <loc>{{ route('home') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <priority>1.0</priority>
        <changefreq>daily</changefreq>
    </sitemap>
    
    <sitemap>
        <loc>{{ route('books.index') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <priority>0.8</priority>
        <changefreq>daily</changefreq>
    </sitemap>
    
    <sitemap>
        <loc>{{ route('guide') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <priority>0.6</priority>
        <changefreq>weekly</changefreq>
    </sitemap>
    
    <!-- Categories -->
    @foreach ($categories as $category)
    <sitemap>
        <loc>{{ route('books.index', ['category' => $category->slug]) }}</loc>
        <lastmod>{{ $category->updated_at->toAtomString() }}</lastmod>
        <priority>0.7</priority>
        <changefreq>weekly</changefreq>
    </sitemap>
    @endforeach
    
    <!-- Books -->
    @foreach ($books as $book)
    <sitemap>
        <loc>{{ route('books.show', $book->id) }}</loc>
        <lastmod>{{ $book->updated_at->toAtomString() }}</lastmod>
        <priority>0.9</priority>
        <changefreq>monthly</changefreq>
    </sitemap>
    @endforeach
</sitemapindex>