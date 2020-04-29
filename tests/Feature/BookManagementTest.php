<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;
    /** @test **/
    public function a_book_can_be_added_to_the_library()
    {
        $data = [
            'title'=> 'Cool Book Title',
            'author' => 'Joel King'
        ];
        $response = $this->post(route('books.store'),$data);
        $response->assertStatus(200);
        $this->assertCount(1, Book::all());

    }
    /** @test **/
    public function a_title_is_required()
    {
        $data = [
            'title'=> null,
            'author' => 'Joel King'
        ];
        $response = $this->post(route('books.store'),$data);
        $response->assertSessionHasErrors('title');
    }
    /** @test **/
    public function a_author_is_required()
    {
        $data = [
            'title'=> 'As Man Thinketh',
            'author' => null
        ];
        $response = $this->post(route('books.store'),$data);
        $response->assertSessionHasErrors('author');
    }
    /** @test **/
    public function a_book_can_be_updated()
    {
        $data = [
            'title'=> 'Cool Book Title',
            'author' => 'Joel King'
        ];
         $this->post(route('books.store'),$data);
         $book = Book::first();

       $response =  $this->patch(route('books.update',$book->id),[
            'title'=> 'New Title',
            'author' => 'New Author'
         ]);
        $response->assertRedirect(route('books.edit',$book->id));
        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);

    }
    /** @test **/
    public function a_book_can_be_deleted()
    {
        $data = [
            'title'=> 'Cool Book Title',
            'author' => 'Joel King'
        ];
        $this->post(route('books.store'),$data);
        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete(route('books.destroy', $book->id));
        $this->assertCount(0, Book::all());
        $response->assertRedirect(route('books.index'));
    }
}
