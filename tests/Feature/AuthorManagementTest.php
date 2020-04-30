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
        $this->post(route('authors.store'), $this->getData());
        $author = Author::all();

        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);

        $this->assertEquals('21-12-1989', $author->first()->dob->format('d-m-Y'));
    }
    /** @test **/
    public function an_author_name_is_required()
    {
        $this->post(route('authors.store'),
            array_merge($this->getData(), array('name'=> null)))->assertSessionHasErrors('name');
    }
    private function getData()
    {
        return [
            'name' => 'Joel Mnisi',
            'dob' => '1989-12-21'
        ];
    }
}
