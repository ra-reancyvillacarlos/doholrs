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
// index and home
Route::match(['get', 'post'], '/', 'ClientController@__index')->name('client.login');
Route::match(['get', 'post'], '/login_user', 'ClientController@__login');
Route::match(['get', 'post'], '/logout_user', 'ClientController@__logout');
Route::match(['get', 'post'], '/client/home', 'ClientController@__home')->name('client.home');
Route::match(['get', 'post'], '/register/verify/{token}', 'ClientController@__rToken');
Route::match(['get', 'post'], '/resend_mail/{uid}', 'ClientController@__rMail');
// apply
Route::match(['get', 'post'], '/client/apply', 'ClientController@__applyForm')->name('client.apply');
// payment
Route::match(['get', 'post'], '/client/payment', 'ClientController@__gPayment')->name('client.payment');
Route::match(['get', 'post'], '/client/payment/{token}/{pmt}', 'ClientController@__pPayment');
// evaluate
Route::match(['get', 'post'], '/client/evaluation', 'ClientController@__evaluate')->name('client.evaluate');