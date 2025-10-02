<?php

use App\Models\Book;
use App\Models\Category;
use App\Models\User;

test('book can be accessed via slug', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $book = Book::factory()->create([
        'judul' => 'Petualangan Si Kancil',
        'slug' => 'petualangan-si-kancil',
        'status' => 'approved',
        'category_id' => $category->id,
        'user_id' => $user->id,
    ]);

    $response = $this->get(route('books.show', $book->slug));

    $response->assertSuccessful();
    $response->assertSee('Petualangan Si Kancil');
});

test('slug is automatically generated when creating book', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $this->actingAs($user);

    $response = $this->post(route('books.store'), [
        'judul' => 'Kisah Sang Pemberani',
        'pengarang' => 'Penulis Test',
        'sinopsis' => 'Sebuah cerita tentang keberanian',
        'category_id' => $category->id,
        'link' => 'https://gemini.google.com/share/test123',
        'cover' => 'https://example.com/cover.jpg',
        'age_min' => 5,
        'age_max' => 10,
    ]);

    $book = Book::where('judul', 'Kisah Sang Pemberani')->first();

    expect($book->slug)->toBe('kisah-sang-pemberani');
});

test('slug is unique when duplicate titles exist', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $book1 = Book::factory()->create([
        'judul' => 'Cerita Menarik',
        'slug' => 'cerita-menarik',
        'category_id' => $category->id,
        'user_id' => $user->id,
    ]);

    $slug2 = Book::generateSlug('Cerita Menarik');

    expect($slug2)->toBe('cerita-menarik-1');

    $book2 = Book::factory()->create([
        'judul' => 'Cerita Menarik',
        'slug' => $slug2,
        'category_id' => $category->id,
        'user_id' => $user->id,
    ]);

    expect($book1->slug)->not->toBe($book2->slug);
});

test('slug is updated when book title is changed', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $book = Book::factory()->create([
        'judul' => 'Judul Lama',
        'slug' => 'judul-lama',
        'status' => 'approved',
        'category_id' => $category->id,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    $response = $this->put(route('books.update', $book), [
        'judul' => 'Judul Baru yang Berbeda',
        'pengarang' => $book->pengarang,
        'sinopsis' => $book->sinopsis,
        'category_id' => $category->id,
        'link' => $book->link,
        'age_min' => $book->age_min,
        'age_max' => $book->age_max,
    ]);

    $book->refresh();

    expect($book->slug)->toBe('judul-baru-yang-berbeda');
});

test('route uses slug as route key', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $book = Book::factory()->create([
        'judul' => 'Test Buku',
        'slug' => 'test-buku',
        'status' => 'approved',
        'category_id' => $category->id,
        'user_id' => $user->id,
    ]);

    $url = route('books.show', $book);

    expect($url)->toContain('test-buku');
    expect($url)->not->toContain($book->id);
});
