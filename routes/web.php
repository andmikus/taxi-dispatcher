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

/**
 *  Resources for Users
 */
Route::resource('/user', 'UserController', [
    'except'     => ['show', 'destroy']
]);

/**
 *  Resources for Orders
 */
Route::resource('/order', 'OrderController');

Route::get('driver', 'DriverController@index')->name('driver.index');;
Route::post('shift', 'DriverController@shift')->name('driver.shift');