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

// トップ
Route::get('/', function () {
    return view('welcome');
});


// 一般ユーザー：設備
Route::get('/equipments', 'EquipmentController@index')
    ->name('equipment.list');

Route::get('/equipments/{id}', 'EquipmentController@show')
    ->name('equipment.detail');


// 一般ユーザー：予約
Route::resource('reservations', 'ReservationController')
    ->only([
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy',
    ])
    ->middleware('auth')
    ->names([
        'index'   => 'reservation.list',
        'create'  => 'reservation.create',
        'store'   => 'reservation.store',
        'show'    => 'reservation.detail',
        'edit'    => 'reservation.edit',
        'update'  => 'reservation.update',
        'destroy' => 'reservation.destroy',
    ]);

Route::post('/reservations/check-availability', 'ReservationController@checkAvailability')
->middleware('auth')
->name('reservation.check_availability');

// 予約確認
Route::post('/reservations/confirm', 'ReservationController@confirm')
    ->middleware('auth')
    ->name('reservation.confirm');

// 予約変更確認
Route::post('/reservations/{id}/edit/confirm', 'ReservationController@editConfirm')
    ->middleware('auth')
    ->name('reservation.edit_confirm');

// キャンセル確認
Route::get('/reservations/{id}/cancel', 'ReservationController@cancelConfirm')
    ->middleware('auth')
    ->name('reservation.cancel_confirm');


// 一般ユーザー：マイページ
Route::get('/mypage', 'MypageController@index')
    ->middleware('auth')
    ->name('mypage');


// パスワード再設定
Route::get('/password/reset-request', 'PasswordResetController@showRequestForm')
    ->name('password.reset.request');

Route::post('/password/reset-request', 'PasswordResetController@sendResetLink')
    ->name('password.reset.send');

Route::get('/password/reset/{token}', 'PasswordResetController@showResetForm')
    ->name('password.reset.form');

Route::post('/password/reset', 'PasswordResetController@resetPassword')
    ->name('password.reset.update');


// 管理者
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        // 管理者トップ
        Route::get('/', 'AdminController@index')
            ->name('admin.top');


        // 予約・履歴管理
        Route::resource('reservations', 'AdminReservationController')
            ->only(['index', 'show'])
            ->names([
                'index' => 'admin.reservations',
                'show'  => 'admin.reservation.detail',
            ]);


        // 設備管理
        Route::resource('equipments', 'AdminEquipmentController')
            ->only([
                'index',
                'create',
                'store',
                'edit',
                'update',
                'destroy',
            ])
            ->names([
                'index'   => 'admin.equipments',
                'create'  => 'admin.equipment.create',
                'store'   => 'admin.equipment.store',
                'edit'    => 'admin.equipment.edit',
                'update'  => 'admin.equipment.update',
                'destroy' => 'admin.equipment.destroy',
            ]);

        // 設備削除確認
        Route::get('/equipments/{id}/delete', 'AdminEquipmentController@deleteConfirm')
            ->name('admin.equipment.delete_confirm');


        // ユーザー利用状況レポート
        Route::get('/users/report', 'AdminUserController@report')
            ->name('admin.user.report');


        // ユーザー管理
        Route::resource('users', 'AdminUserController')
            ->only([
                'index',
                'create',
                'store',
                'destroy',
            ])
            ->names([
                'index'   => 'admin.users',
                'create'  => 'admin.user.create',
                'store'   => 'admin.user.store',
                'destroy' => 'admin.user.destroy',
            ]);

        // ユーザー削除確認
        Route::get('/users/{id}/delete', 'AdminUserController@deleteConfirm')
            ->name('admin.user.delete_confirm');
    });


// Laravel認証
Auth::routes([
    'register' => false,
    'reset' => false,
]);

Route::get('/home', 'HomeController@index')
    ->name('home');