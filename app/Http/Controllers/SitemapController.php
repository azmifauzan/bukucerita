<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;

class SitemapController extends Controller
{
    public function index()
    {
        $books = Book::approved()
            ->select('id', 'updated_at')
            ->latest('updated_at')
            ->get();

        $categories = Category::select('slug', 'updated_at')
            ->latest('updated_at')
            ->get();

        return response()->view('sitemap.index', compact('books', 'categories'))
            ->header('Content-Type', 'application/xml');
    }

    public function books()
    {
        $books = Book::approved()
            ->with(['category'])
            ->select('id', 'judul', 'sinopsis', 'updated_at', 'category_id')
            ->latest('updated_at')
            ->get();

        return response()->view('sitemap.books', compact('books'))
            ->header('Content-Type', 'application/xml');
    }
}
