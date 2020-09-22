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

Route::apiResources([
    'donators' => \App\Http\Controllers\Api\DonatorController::class
]);


Route::get('user-data/get-by-user-id/{id}', [ \App\Http\Controllers\Api\UserDataController::class, 'getByIdUser'] );
Route::get('payment-method/{type}/get-by-user-id/{id}', [ \App\Http\Controllers\Api\PaymentMethodController::class, 'getByIdUser' ] );
Route::get('donation/get-by-user-id/{id}', [ \App\Http\Controllers\Api\DonationController::class, 'getByIdUser' ] );
