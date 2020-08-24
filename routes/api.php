<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Catch all options requests routes
Route::options('{any?}', function () {
    return \App\Helpers\ResponseHelper::createSuccessResponse([]);
})->where('any', '.*');

//health check port
Route::any('/health-check', function() {
    //redis connection is checked by default cause it's used for session storage
    //and all requests to the server creates a session by default
    //check if the database is connected
    \Illuminate\Support\Facades\DB::reconnect();

    return \App\Helpers\ResponseHelper::createSuccessResponse([]);
});

Route::post('/admin/sim-login', 'SimAuthController@login');

Auth::routes();

Route::apiResource('country', 'CountryController');
Route::apiResource('role', 'RoleController');
Route::apiResource('permission', 'PermissionController');
Route::apiResource('competition', 'CompetitionController');
Route::apiResource('club', 'ClubController');
Route::apiResource('market', 'MarketController');
Route::apiResource('odd', 'OddController');
Route::apiResource('sport', 'SportController');
Route::apiResource('game_status', 'GameStatusController');
Route::apiResource('game', 'GameController');
Route::apiResource('user', 'UserController');
Route::apiResource('game_item', 'GameItemController');
Route::apiResource('bookmaker', 'BookmakerController');
Route::apiResource('image', 'ImageController');


Route::post('/me', 'Auth\MeController@me');
Route::post('user/{user}/roles', 'UserController@manageRoles');
Route::post('user/{user}/permissions', 'UserController@managePermissions');
Route::post('role/{role}/permissions', 'RoleController@managePermissions');
Route::patch('club/{club}/competitions', 'ClubController@manageCompetitions');
Route::patch('game/{game}/odds', 'GameController@manageOdds');
Route::patch('game_item/{game_item}/odds', 'GameItemController@manageOdds');
Route::post('image/{image}', 'ImageController@updateImage');
//Route::put('/image/{image}', 'ImageController@update');

//Slip Endpoints
Route::get('/slip', ['uses' => 'SlipController@getSlip']);
Route::post('/slip', ['uses' => 'SlipController@modifySlip']);
Route::delete('/slip_item', ['uses' => 'SlipItemController@delete']);
Route::delete('/slip/{slip}', ['uses' => 'SlipController@delete']);
Route::put('/slip/{slip}', ['uses' => 'SlipController@update']);
Route::post('/slip/{slip}/checkout', ['uses' => 'SlipController@checkout']);
Route::post('/bookmaker_game/{game}/{bookmaker}', ['uses' => 'BookmakerGameController@addBooking']);
Route::delete('/bookmaker_game/{game}/{bookmaker}', ['uses' => 'BookmakerGameController@removeBooking']);

Route::get('/tracker/visitor', ['uses' => 'TrackerController@visitor']);
Route::get('/tracker/session', ['uses' => 'TrackerController@session']);
