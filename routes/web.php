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
