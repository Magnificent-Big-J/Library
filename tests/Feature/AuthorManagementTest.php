<?php

namespace Tests\Feature;

use App\Author;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test  */
    public function an_author_can_created()
    {
        $this->post(route('authors.store'),
        [
            'name' => 'Joel Mnisi',
            'dob' => '1989-12-21'
        ]);
        $author = Author::all();

        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);

        $this->assertEquals('21-12-1989', $author->first()->dob->format('d-m-Y'));
    }
}
