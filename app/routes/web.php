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

Route::post('/reservations/confirm', 'ReservationController@confirm')
    ->middleware('auth')
    ->name('reservation.confirm');

Route::resource('reservations', 'ReservationController')
    ->only(['index','create', 'store', 'show', 'edit','update', 'destroy'])
    ->middleware('auth')
    ->names([
        'index' => 'reservation.list',
        'create' => 'reservation.create',
        'store' => 'reservation.store',
        'show' => 'reservation.detail',
        'edit' => 'reservation.edit',
        'update' => 'reservation.update',
        'destroy' => 'reservation.destroy',
    ]);

Route::post('/reservations/{id}/edit/confirm', 'ReservationController@editConfirm')
    ->middleware('auth')
    ->name('reservation.edit_confirm');

Route::get('/reservations/{id}/cancel', 'ReservationController@cancelConfirm')
    ->middleware('auth')
    ->name('reservation.cancel_confirm');

Route::get('/mypage', 'MypageController@index')
    ->middleware('auth')
    ->name('mypage');

Route::get('/password/reset-request', 'PasswordResetController@showRequestForm')
->name('password.reset.request');

Route::post('/password/reset-request', 'PasswordResetController@sendResetLink')
    ->name('password.reset.send');

Route::get('/password/reset/{token}', 'PasswordResetController@showResetForm')
->name('password.reset.form');
Auth::routes([
    'register' => false,
    'reset' => false,
]);

Route::get('/home', 'HomeController@index')->name('home');
