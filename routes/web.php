<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::resource('books','BookController');
Route::resource('authors','AuthorController');
Route::post('/checkout/{book}','CheckoutController@store')->name('reservation.checkout');
Route::post('/checkin/{book}','CheckinController@store')->name('reservation.checkin');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
