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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'is_organizer'], function () {
    Route::resource('/wishlist', 'WishlistController');
    Route::get('/wishlist/items/{id}', 'WishlistController@getItemsView');
    Route::get('/wishlist/{id}/items', 'WishlistController@getItems');
    Route::resource('/wishlistitem', 'WishlistItemController');
});

Route::get('/share/{uuid}', 'ShareWishlistController@show')->name('share');
Route::get('/sharedetails/{uuid}', 'ShareWishlistController@showWishlistDetails');


Route::get('/invitee/wishlist/', 'InviteeWishlistController@wishlists');
Route::get('/invitee/wishlist/items/{id}', 'InviteeWishlistController@getItemsView');
Route::get('/invitee/wishlist/{id}/items', 'InviteeWishlistController@getItems');
Route::post('/invitee/wishlistitem/buyitem/', 'InviteeWishlistController@buyItem');
Route::post('/invitee/wishlistitem/buyitems/', 'InviteeWishlistController@buyItems');

