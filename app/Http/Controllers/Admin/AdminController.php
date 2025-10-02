<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminController extends Controller
{
    // Check admin access in each method instead of constructor
    protected function checkAdminAccess(): void
    {
        if (! Auth::user()?->isAdmin()) {
            abort(403, 'Access denied');
        }
    }

    public function index()
    {
        $this->checkAdminAccess();

        $stats = [
            'total_books' => Book::count(),
            'approved_books' => Book::where('status', 'approved')->count(),
            'pending_books' => Book::where('status', 'pending')->count(),
            'total_users' => User::count(),
            'total_categories' => Category::count(),
        ];

        $pendingBooks = Book::where('status', 'pending')
            ->with(['category', 'user'])
            ->latest()
            ->take(10)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'pendingBooks' => $pendingBooks,
        ]);
    }

    public function books(Request $request)
    {
        $this->checkAdminAccess();

        $query = Book::with(['category', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('pengarang', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $books = $query->latest()->paginate(15)->withQueryString();

        return Inertia::render('Admin/Books', [
            'books' => $books,
            'filters' => $request->only(['status', 'search']),
        ]);
    }

    public function approveBook(Book $book)
    {
        $this->checkAdminAccess();

        $book->update(['status' => 'approved']);

        return back()->with('message', 'Buku berhasil disetujui!');
    }

    public function rejectBook(Request $request, Book $book)
    {
        $this->checkAdminAccess();

        $book->update(['status' => 'rejected']);

        return back()->with('message', 'Buku berhasil ditolak!');
    }

    public function categories()
    {
        $this->checkAdminAccess();

        $categories = Category::withCount('books')->paginate(10);

        return Inertia::render('Admin/Categories', [
            'categories' => $categories,
        ]);
    }

    public function storeCategory(Request $request)
    {
        $this->checkAdminAccess();

        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'description' => $request->description,
        ]);

        return back()->with('message', 'Kategori berhasil ditambahkan!');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $this->checkAdminAccess();

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'description' => $request->description,
        ]);

        return back()->with('message', 'Kategori berhasil diperbarui!');
    }

    public function destroyCategory(Category $category)
    {
        $this->checkAdminAccess();

        if ($category->books()->count() > 0) {
            return back()->withErrors(['message' => 'Tidak dapat menghapus kategori yang masih memiliki buku!']);
        }

        $category->delete();

        return back()->with('message', 'Kategori berhasil dihapus!');
    }
}
