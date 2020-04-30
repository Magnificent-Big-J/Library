<?php

namespace Tests\Feature;

use App\Author;
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

        $response = $this->post(route('books.store'),$this->getData());
        $response->assertStatus(200);
        $this->assertCount(1, Book::all());

    }
    /** @test **/
    public function a_title_is_required()
    {
        $response = $this->post(route('books.store'),array_merge($this->getData(),array('title' => null)));
        $response->assertSessionHasErrors('title');
    }
    /** @test **/
    public function a_author_id_is_required()
    {
        $response = $this->post(route('books.store'),array_merge($this->getData(),array('author_id' => null)));
        $response->assertSessionHasErrors('author_id');
    }
    /** @test **/
    public function a_book_can_be_updated()
    {
       $this->post(route('books.store'),$this->getData());
       $book = Book::first();

       $response =  $this->patch(route('books.update',$book->id), $this->newData());

        //$response->assertRedirect(route('books.edit',$book->id));
        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);

    }
    /** @test **/
    public function a_book_can_be_deleted()
    {

        $this->post(route('books.store'),$this->getData());
        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete(route('books.destroy', $book->id));
        $this->assertCount(0, Book::all());
        $response->assertRedirect(route('books.index'));
    }
    /** @test **/
    public function a_new_author_is_automatically_added()
    {

       $this->post(route('books.store'),$this->getData());

        $book = Book::first();
        $author = Author::first();

        $this->assertCount(1, Author::all());
        $this->assertEquals($author->id,$book->author_id);
    }

    private function getData()
    {
      return  [
            'title'=> 'Cool Book Title',
            'author_id'=>['name' => 'Joel King',
                'dob' => '1989-12-21']
        ];
    }
    private function newData()
    {
        return  [
            'title'=> 'New Title',
            'author_id'=>['name' => 'John Doe',
                'dob' => '1989-12-21']
        ];
    }

}
