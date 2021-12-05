<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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



$router->get('/fasilitas', function () use ($router) {
    $results = app('db')->select("SELECT * FROM fasilitas");
    return response()->json($results);
});

$router->get('/detailfasilitas', function () use ($router) {
    $results = app('db')->select("SELECT * FROM detail_fasilitas");
    return response()->json($results);
});

$router->post('register', 'UserController@register');
$router->post('login','AuthController@login');

// $router->get('api/homestay', "HomestayController@listHomestay");

$router->group(['middleware' => 'auth'], function() use ($router){

    $router->get('api/homestay', "HomestayController@index");
    $router->post('api/homestay/store', "HomestayController@store");
    $router->get('api/homestay/{id}','HomestayController@show');

    $router->get('api/review', "ReviewController@index");
    $router->post('api/review/store', "ReviewController@store");
    $router->get('api/review/{id}','ReviewController@show');

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
    $router->get('api/dfasilitas/{id}','DetailFasilitasController@show');

    $router->get('api/duser', "DetailUserController@index");
    $router->post('api/duser/store', "DetailUserController@store");
    $router->get('api/duser/{id}','DetailUserController@show');

    $router->get('api/user/{id}','UserController@show');
    $router->post('logout', 'AuthController@logout');
});
