<?php

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    use MockeryPHPUnitIntegration;
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function seeHasHeader($header)
    {
        $this->assertTrue(
            $this->response->headers->has($header), 
            "Response should have the header '{$header}' bot does not."
        );

        return $this;
    }

    public function seeHeaderWithRegExp($header, $regexp)
    {
        $this->seeHasHeader($header)
            ->assertRegExp(
                $regexp,
                $this->response->headers->get($header)
            );

        return $this;
    }

    /**
    * Convenience method for creating a book with an author 56 *
    * @param int $count
    * @return mixed
    */
    protected function bookFactory($count = 1)
    {
        $author = factory(\App\Author::class)->create();
        // $books = factory(\App\Book::class, $count)->make();
        if ($count === 1) {
            $book = factory(\App\Book::class)->make();
            $book->author()->associate($author);
            $book->save();
            
            return $book;
            
        } else {
            $books = factory(\App\Book::class, $count)->make();

            $books->each(function ($book) use ($author) {
                $book->author()->associate($author);
                $book->save();
            });
        }

        return $books;
    }
}
