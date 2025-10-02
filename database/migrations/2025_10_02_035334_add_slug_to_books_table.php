<?php

use App\Models\Book;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add nullable slug column first
        Schema::table('books', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('judul');
        });

        // Generate slugs for existing books
        $books = Book::all();
        foreach ($books as $book) {
            $book->slug = Book::generateSlug($book->judul, $book->id);
            $book->save();
        }

        // Make slug unique and not nullable
        Schema::table('books', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
