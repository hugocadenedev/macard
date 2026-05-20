<?php

use App\Booking;
use App\Page;
use Illuminate\Support\Facades\Route;

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
  Route::group(['prefix' => 'admin',  'middleware' => 'auth'], function()
  {
    Route::get('/',                 'AdminController@index')->name('admin');
    Route::resource('/cars',        'CarController');
    Route::resource('/commercials', 'CommercialController');
    Route::resource('/page',        'PageController');
    Route::resource('/sites',       'SiteController');
    Route::get('/builder/html',     'BuilderController@html');
    Route::resource('/builder',     'BuilderController');
  });
  Route::get('/',                       'HomeController@index')->name('home');
  Route::get('/offer',                  'OfferController@index');
  Route::post('/bookings',              'HomeController@bookings');
  Route::resource('/api/slots',         'SlotsController');
  Route::resource('/api/bookings',      'BookingController');
  Route::resource('/api/booking_types',      'BookingTypeController');

  Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
  Route::post('login', 'Auth\LoginController@login');
  Route::post('logout', 'Auth\LoginController@logout')->name('logout');


Route::get('mail', function() {
  $b = Booking::first();
  $b->load("slot.site");
  $page = Page::first();
  return view("mail.alertMail", [
    'booking' => $b
  ]);
});


