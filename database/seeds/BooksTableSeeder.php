<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authors = factory(App\Author::class, 10)->create();
        $authors->each(function ($author) {
            $author->ratings()->saveMany(
                factory(App\Rating::class, rand(20, 50))->make()
            );

            $booksCount = rand(1, 5);
            while ($booksCount > 0) { 
                $book = $author->books()->save(factory(App\Book::class)->make()); 
                $book->ratings()->saveMany(
                    factory(App\Rating::class, rand(20, 50))->make()
                );
                $booksCount--;
            }
        });
    }
}
