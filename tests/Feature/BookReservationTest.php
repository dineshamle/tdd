<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();
        $resonse = $this->post('/books',[
            'title' => 'book title',
            'author' => 'Dinesh',
        ]);
        
        $resonse->assertOk();
        $this->assertCount(1, Book::all());

    }

    /** @test */
    public function a_title_is_required()
    {
        // $this->withoutExceptionHandling();
        $resonse = $this->post('/books',[
            'title' => '',
            'author' => 'Dinesh',
        ]);
        
        $resonse->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_author_is_required()
    {
        // $this->withoutExceptionHandling();
        $resonse = $this->post('/books',[
            'title' => 'cool title',
            'author' => '',
        ]);
        
        $resonse->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books',[
            'title' => 'cool title',
            'author' => 'dinesh',
        ]);

        $book = Book::first();
        
        $resonse = $this->patch('/books/' . $book->id,[
            'title' => 'new title',
            'author' => 'DInesh',
        ]);

        $this->assertEquals('new title', Book::first()->title);
        $this->assertEquals('DInesh', Book::first()->author);
    }
}
