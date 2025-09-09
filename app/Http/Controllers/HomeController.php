<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $featuredBooks = Book::approved()
            ->with(['category', 'user'])
            ->orderBy('views', 'desc')
            ->take(6)
            ->get();

        $recentBooks = Book::approved()
            ->with(['category', 'user'])
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::withCount(['books' => function ($query) {
            $query->approved();
        }])->get();

        return Inertia::render('Home', [
            'featuredBooks' => $featuredBooks,
            'recentBooks' => $recentBooks,
            'categories' => $categories,
        ]);
    }
}
