<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Tour;
use App\Tourdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        $tour = Tour::orderBy('created_at', 'asc')->get();

        return view('home', [
            'tours' => $tour
        ]);
    });

    Route::get('/create_tour', 'AjaxController@store');

    Route::get('/edit_tour/{id}', 'AjaxController@update');

    Route::get('/booking/{id}', 'AjaxController@booking');

    Route::get('/booking_list', 'AjaxController@booking_list');

    Route::get('/booking_edit/{id}', 'AjaxController@booking_edit');
});
