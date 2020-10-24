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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["prefix" => "auth"], function () {
    Route::post("register", ["uses" => "AuthController@register", "as" => "auth.register"]);
    Route::post("login", "AuthController@postLogin")->name("auth.login");
    Route::post("users/{id}/reset-password", "AuthController@resetPassword")->name("auth.reset-password")->middleware(["auth:api"]);
    Route::post("users/change-password", "AuthController@changePassword")->name("auth.change-password")->middleware(["auth:api"]);
});

Route::group(["prefix" => "patients", "middleware" => ["auth:api"]], function () {
    Route::post("add", "PatientsController@addPatient")->name("patients.add");
    Route::get("first-visit", "PatientsController@firstVisit")->name("patients.first-visit");
    Route::get("second-visit", "PatientsController@secondVisit")->name("patients.second-visit");
    Route::post("update-first-visit", "PatientsController@updateFirstVisit")->name("update.first");
    Route::post("update-second-visit", "PatientsController@updateSecondVisit")->name("update.second");
    Route::get("missed-first-visit", "PatientsController@overdueFirstVisit")->name("missed-first");
    Route::get("missed-second-visit", "PatientsController@overdueSecondVisit")->name("missed-second");
    Route::post("update-missed-first-visit", "PatientsController@updateMissedFirstVisit");
    Route::post("update-missed-second-visit", "PatientsController@updateMissedSecondVisit");
    Route::post("search", "PatientsController@searchPatient")->name("search");
    Route::get("all", "PatientsController@allPatients")->name("all");

});
