<?php

namespace Tests\Feature;

use App\Book;
use App\Reservation;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookCheckOutTest extends TestCase
{
    use RefreshDatabase;
    /** @test **/
    public function a_book_can_be_checked_out_by_a_signed_user()
    {
        $user = factory(User::class)->create();
        $this->authenticateUser($user);

        $book = factory(Book::class)->create();

        $this->post(route('reservation.checkout', $book->id));

        $reservation = Reservation::all();
        $this->assertCount(1, $reservation);
        $this->assertEquals($user->id, $reservation->first()->user_id);
        $this->assertEquals($book->id, $reservation->first()->book_id);
        $this->assertEquals(now(), $reservation->first()->check_out_at);
    }
    /** @test **/
    public function only_signed_in_users_can_check_out_a_book()
    {
        $book = factory(Book::class)->create();

        $this->post(route('reservation.checkout', $book->id))->assertRedirect('/login');
        $this->assertCount(0, Reservation::all());

    }
    /** @test **/
    public function only_existing_book_can_be_checked_out()
    {
        $user = factory(User::class)->create();
        $this->authenticateUser($user);

        $this->post(route('reservation.checkout', 'invalid_id'))->assertStatus(404);
        $this->assertCount(0, Reservation::all());
    }
    /** @test **/
    public function a_book_can_be_checked_in_by_signed_in_user()
    {
        $user = factory(User::class)->create();
        $this->authenticateUser($user);
        $book = factory(Book::class)->create();

        $this->post(route('reservation.checkout', $book->id));
        $this->post(route('reservation.checkin', $book->id));

        $reservation = Reservation::all();
        $this->assertCount(1, $reservation);
        $this->assertEquals($user->id, $reservation->first()->user_id);
        $this->assertEquals($book->id, $reservation->first()->book_id);
        $this->assertEquals(now(), $reservation->first()->check_in_at);
    }

    /** @test **/
    public function only_signed_in_users_can_check_in_a_book()
    {
        $user = factory(User::class)->create();
        $this->authenticateUser($user);
        $book = factory(Book::class)->create();

        $this->post(route('reservation.checkout', $book->id));
        auth()->logout();

        $this->post(route('reservation.checkin', $book->id))->assertRedirect('login');
        $this->assertCount(1, Reservation::all());
        $this->assertNull(Reservation::first()->check_in_at);
    }
    /** @test **/
    public function a_404_is_thrown_if_a_booK_is_not_checkd_out_first()
    {
        $user = factory(User::class)->create();
        $this->authenticateUser($user);
        $book = factory(Book::class)->create();

        $this->post(route('reservation.checkin', $book->id))->assertStatus(404);
        $this->assertCount(0, Reservation::all());

    }
}
