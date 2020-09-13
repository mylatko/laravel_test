<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/', '\App\Http\Controllers\HomeController@index')->name('home');

//Book routes
Route::get('/book/create', '\App\Http\Controllers\BookController@create')->name('book.create');
Route::post('/book', '\App\Http\Controllers\BookController@store')->name('book');
Route::get('/book/{book}/edit', '\App\Http\Controllers\BookController@edit')->name('book.edit');
Route::delete('/book/{book}', '\App\Http\Controllers\BookController@destroy')->name('book.delete');
Route::patch('/book/{book}', '\App\Http\Controllers\BookController@update')->name('book.update');
//Route::resource('book', 'BookController');

//Rent routes
Route::get('rent', '\App\Http\Controllers\RentController@index')->name('rent');
Route::patch('rent/{book}', '\App\Http\Controllers\RentController@rent')->name('rent.create');
Route::patch('rent/{book}/prolong', '\App\Http\Controllers\RentController@prolong')->name('rent.prolong');
