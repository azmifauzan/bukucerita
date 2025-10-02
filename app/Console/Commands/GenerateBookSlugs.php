<?php

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Console\Command;

class GenerateBookSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:generate-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate slugs for all books that do not have one';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Generating slugs for books...');

        $books = Book::whereNull('slug')->orWhere('slug', '')->get();

        if ($books->isEmpty()) {
            $this->info('All books already have slugs!');

            return Command::SUCCESS;
        }

        $bar = $this->output->createProgressBar($books->count());
        $bar->start();

        foreach ($books as $book) {
            $book->slug = Book::generateSlug($book->judul, $book->id);
            $book->save();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Successfully generated slugs for {$books->count()} books!");

        return Command::SUCCESS;
    }
}
