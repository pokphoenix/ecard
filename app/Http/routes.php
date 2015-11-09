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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


Route::get('ecard', 'EcardController@index');
Route::post('ecard', 'EcardController@postIndex');
Route::post('ecard-facebook', 'EcardController@postFacebook');
Route::post('ecard-ajax', 'EcardController@postAjax');
Route::get('ecard-gallery-view', 'EcardController@gallery');
Route::get('ecard-gallery-search/{text}', 'EcardController@gallerySearch');
Route::get('ecard-gallery-select/{id}', 'EcardController@gallerySelect');


Route::get('ecard-copper', 'EcardController@copperIndex');
Route::post('ecard-copper-ajax', 'EcardController@postAjaxCopper');


Route::get('html2canvas', 'TestController@html2canvas');

