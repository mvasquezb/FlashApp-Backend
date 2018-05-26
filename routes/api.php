<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('animal-types', 'AnimalTypeController');
Route::resource('pets', 'PetController');
Route::get('users/{userid}/pets', 'PetController@getMascotas');
Route::resource('users', 'UserController');
Route::resource('service-types', 'ServiceTypeController');
Route::resource('scheduled-services', 'ScheduledServices');
Route::resource('schedules', 'ScheduleController');
Route::resource('service-requests', 'ServiceRequestController');
Route::resource('service-status', 'ServiceStatusController');
Route::resource('services', 'ServiceController');
Route::resource('service-customers', 'ServiceCustomerController');
