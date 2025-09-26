<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BookController extends Controller
{
    /**
     * Display a listing of the resource - Collection page with search
     */
    public function index(Request $request)
    {
        $query = Book::approved()->with(['category', 'user']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('pengarang', 'like', "%{$search}%")
                    ->orWhere('sinopsis', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Age filter
        if ($request->filled('age')) {
            $age = (int) $request->age;
            $query->forAge($age);
        }

        $books = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::withCount(['books' => function ($query) {
            $query->approved();
        }])->get();

        return Inertia::render('Books/Collection', [
            'books' => $books,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category', 'age']),
        ]);
    }

    /**
     * Show the form for creating a new resource - Upload page
     */
    public function create()
    {
        $categories = Category::all();

        return Inertia::render('Books/Upload', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'sinopsis' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'link' => 'required|url',
            'cover' => 'nullable|url',
            'youtube_link' => 'nullable|url',
            'age_min' => 'required|integer|min:1|max:18',
            'age_max' => 'required|integer|min:1|max:18|gte:age_min',
        ]);

        Book::create([
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'sinopsis' => $request->sinopsis,
            'category_id' => $request->category_id,
            'link' => $request->link,
            'cover' => $request->cover,
            'youtube_link' => $request->youtube_link,
            'age_min' => $request->age_min,
            'age_max' => $request->age_max,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        return redirect()->route('books.create')
            ->with('message', 'Buku berhasil diupload! Menunggu persetujuan admin.');
    }

    /**
     * Display the specified resource - Book detail page
     */
    public function show(Book $book)
    {
        // Only show approved books or user's own books (allow guests for approved books)
        if ($book->status !== 'approved' && (! Auth::check() || $book->user_id !== Auth::id())) {
            abort(404);
        }

        $book->load(['category', 'user']);
        $book->incrementViews();

        $relatedBooks = Book::approved()
            ->where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->with(['category', 'user'])
            ->take(4)
            ->get();

        return Inertia::render('Books/Detail', [
            'book' => $book,
            'relatedBooks' => $relatedBooks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        // Only allow editing own books
        if ($book->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all();

        return Inertia::render('Books/Edit', [
            'book' => $book,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        // Only allow editing own books
        if ($book->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'sinopsis' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'link' => 'required|url',
            'cover' => 'nullable|url',
            'youtube_link' => 'nullable|url',
            'age_min' => 'required|integer|min:1|max:18',
            'age_max' => 'required|integer|min:1|max:18|gte:age_min',
        ]);

        $book->update([
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'sinopsis' => $request->sinopsis,
            'category_id' => $request->category_id,
            'link' => $request->link,
            'cover' => $request->cover,
            'youtube_link' => $request->youtube_link,
            'age_min' => $request->age_min,
            'age_max' => $request->age_max,
            'status' => 'pending', // Reset to pending after edit
        ]);

        return redirect()->route('books.show', $book)
            ->with('message', 'Buku berhasil diperbarui! Menunggu persetujuan admin.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // Only allow deleting own books or admin
        if ($book->user_id !== Auth::id() && ! Auth::user()?->isAdmin()) {
            abort(403);
        }

        $book->delete();

        return redirect()->route('books.index')
            ->with('message', 'Buku berhasil dihapus.');
    }
}
