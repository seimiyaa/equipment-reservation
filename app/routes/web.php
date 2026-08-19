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

Route::get('/equipments', 'EquipmentController@index')->name('equipment.list');
Route::get('/equipments/{id}', 'EquipmentController@show')->name('equipment.detail');
Route::get('/reservations/create/{equipment_id}', 'ReservationController@create')
    ->middleware('auth')
    ->name('reservation.create');
Route::post('/reservations/confirm', 'ReservationController@confirm')->name('reservation.confirm');Route::post('/reservations/confirm', 'ReservationController@confirm')
    ->middleware('auth')
    ->name('reservation.confirm');
Route::post('/reservations/store', 'ReservationController@store')->name('reservation.store');Route::post('/reservations/store', 'ReservationController@store')
    ->middleware('auth')
    ->name('reservation.store');
Route::get('/reservations', 'ReservationController@index')->name('reservation.list');Route::get('/reservations', 'ReservationController@index')
    ->middleware('auth')
    ->name('reservation.list');
Route::get('/reservations/{id}', 'ReservationController@show')->name('reservation.detail');Route::get('/reservations/{id}', 'ReservationController@show')
    ->middleware('auth')
    ->name('reservation.detail');
Route::get('/reservations/{id}/edit', 'ReservationController@edit')->name('reservation.edit');Route::get('/reservations/{id}/edit', 'ReservationController@edit')
    ->middleware('auth')
    ->name('reservation.edit');
Route::post('/reservations/{id}/edit/confirm', 'ReservationController@editConfirm')->name('reservation.edit_confirm');Route::post('/reservations/{id}/edit/confirm', 'ReservationController@editConfirm')
    ->middleware('auth')
    ->name('reservation.edit_confirm');
Route::post('/reservations/{id}/update', 'ReservationController@update')->name('reservation.update');Route::post('/reservations/{id}/update', 'ReservationController@update')
    ->middleware('auth')
    ->name('reservation.update');
Route::get('/reservations/{id}/cancel', 'ReservationController@cancelConfirm')->name('reservation.cancel_confirm');Route::get('/reservations/{id}/cancel', 'ReservationController@cancelConfirm')
    ->middleware('auth')
    ->name('reservation.cancel_confirm');
Route::post('/reservations/{id}/cancel', 'ReservationController@cancel')->name('reservation.cancel');Route::post('/reservations/{id}/cancel', 'ReservationController@cancel')
    ->middleware('auth')
    ->name('reservation.cancel');
Route::get('/mypage', 'MypageController@index')
    ->middleware('auth')
    ->name('mypage');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
