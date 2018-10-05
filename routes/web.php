<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
    return $router->app->version();
});

$router->get('/hello/world', function () { 
    return "Hello world!!!";
});

$router->get('/hello/{name}', ['middleware' => 'hello', function ($name) {
    return "Hello {$name}"; 
}]);

$router->get('/response', function (Request $request) {
    if ($request->wantsJson()) {
        return response()->json(['greeting' => 'Hello stranger']); 
    }

    return (new Response('Hello stranger', 200))
        ->header('Content-Type', 'text/plain');
});

$router->get('/books', 'BooksController@index');
$router->get('/books/{id:[\d]+}', [
    'as' => 'books.show',
    'uses' => 'BooksController@show'
]);
$router->post('/books', 'BooksController@store');
$router->put('/books/{id:[\d]+}', 'BooksController@update');
$router->delete('/books/{id:[\d]+}', 'BooksController@destroy');

$router->group([
    'prefix' => '/authors',
    // 'namespace' => 'App\Http\Controllers'
], function() use ($router) {
    $router->get('/', 'AuthorsController@index');
    $router->post('/', 'AuthorsController@store');
    $router->get('/{id:[\d]+}', [
        'as' => 'authors.show',
        'uses' => 'AuthorsController@show'
    ]);
    $router->put('/{id:[\d]+}', 'AuthorsController@update');
    $router->delete('/{id:[\d]+}', 'AuthorsController@destroy');
});

$router->group([
    'prefix' => '/bundles',
    // 'namespace' => 'App\Http\Controllers'
], function() use ($router) {
    $router->get('/{id:[\d]+}', [
        'as' => 'bundles.show',
        'uses' => 'BundlesController@show'
    ]);
    $router->put('/{BundleId:[\d]+}/books/{bookId:[\d]+}', 'BundlesController@addBook');
    $router->delete('/{BundleId:[\d]+}/books/{bookId:[\d]+}', 'BundlesController@removeBook');
});