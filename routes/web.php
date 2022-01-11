<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return ["Hello Hai..!!!"];
});

$router->get('data', function () use ($router) {
    $results = app('db')->select("SELECT * FROM users");
    return response()->json($results);
});



$router->post('register', 'UserController@register');
$router->post('login', 'AuthController@login');
$router->get('api/duserOtp/{phone}', 'UserController@otp');
$router->post('api/otpUser', 'AuthController@login_hp');

// $router->get('api/homestay', "HomestayController@listHomestay");

$router->group(['middleware' => 'auth'], function () use ($router) {

    $router->get('api/homestay', "HomestayController@index");
    $router->post('api/homestay/store', "HomestayController@store");
    $router->get('api/homestay/{id}', 'HomestayController@show');

    $router->get('api/dhome/{id}', 'HomestayController@detail');

    $router->get('api/review', "ReviewController@index");
    $router->post('api/review/store', "ReviewController@store");
    $router->post('api/updateReview/{id}', 'ReviewController@update');
    $router->get('api/review/{id}', 'ReviewController@show');
    $router->get('api/review/{id_user}/{id_homestay}', 'ReviewController@look');

    // $router->get('/api/homestay', function () use ($router) {
    //     $results = app('db')->select("SELECT * FROM homestays join jenis on jenis.id = homestays.jenis_id");
    //     return response()->json($results);
    // });
    $router->get('api/jenis', "JenisController@index");
    $router->post('api/jenis/store', "JenisController@store");

    $router->get('api/fasilitas', "FasilitasController@index");
    $router->post('api/fasilitas/store', "FasilitasController@store");

    $router->get('api/dfasilitas', "DetailFasilitasController@index");
    $router->post('api/dfasilitas/store', "DetailFasilitasController@store");
    $router->get('api/dfasilitas/{id}', 'DetailFasilitasController@show');

    $router->get('api/unit', 'UnitController@index');
    $router->post('api/unit/store', 'UnitController@store');
    $router->get('api/unit/{id}', 'UnitController@show');

    $router->get('api/pembayaran', 'PembayaranController@index');
    $router->post('api/pembayaran/store', 'PembayaranController@store');
    $router->get('api/pembayaran/{id}', 'PembayaranController@show');

    $router->get('api/duser', "DetailUserController@index");
    $router->post('api/duser/store', "DetailUserController@store");
    $router->get('api/duser/{id}', 'DetailUserController@show');

    $router->get('api/user/{id}', 'UserController@show');
    $router->post('api/user/update/{id}', "UserController@update");

    $router->get('api/avatar', 'AvatarController@index');

    $router->get('api/listBelum', 'BookingController@belum');
    $router->get('api/listSudah', 'BookingController@sudah');

    $router->post('api/booking/store', 'BookingController@store');
    $router->get('api/booking/{id}', 'BookingController@show');
    $router->get('api/history', 'BookingController@history');

    $router->get('api/notifikasi', 'NotifikasiController@index');
    $router->post('api/notifikasi/store', 'NotifikasiController@store');

    $router->post('api/notifikasi/store', 'NotifikasiController@store');
    $router->get('api/notifikasi/show', 'NotifikasiController@show');

    $router->post('api/reminder/{id}', 'BookingController@reminder');
    $router->post('api/booked/{id}', 'BookingController@booking');
    $router->post('api/cancel/{id}', 'BookingController@cancel');

    $router->post('logout', 'AuthController@logout');
});
