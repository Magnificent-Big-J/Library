<?php

namespace Tests\Unit;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function an_author_id_is_recorded()
    {
        Book::create( $this->getData());

        $this->assertCount(1, Book::all());
    }
    private function getData()
    {
        return [
            'title' => 'New Title',
            'author_id' => [
                'name' => 'Joel Mnisi',
                'dob' => '1989-12-21'
            ]
        ];
    }

}
