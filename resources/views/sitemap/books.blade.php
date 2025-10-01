<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach ($books as $book)
    <url>
        <loc>{{ route('books.show', $book->id) }}</loc>
        <lastmod>{{ $book->updated_at->toAtomString() }}</lastmod>
        <priority>0.9</priority>
        <changefreq>monthly</changefreq>
        @if ($book->cover)
        <image:image>
            <image:loc>{{ $book->cover }}</image:loc>
            <image:caption>Cover buku cerita {{ $book->judul }} - {{ $book->category->name }}</image:caption>
            <image:title>{{ $book->judul }}</image:title>
        </image:image>
        @endif
    </url>
    @endforeach
</urlset>