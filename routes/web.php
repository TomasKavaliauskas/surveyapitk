<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Frontend\MainController@index');
Route::get('/api', 'Frontend\MainController@api');

/*
Route::get('register', 'Frontend\AuthController@register')->middleware('guest');
Route::get('login', 'Frontend\AuthController@login')->middleware('guest');
Route::post('login', 'Frontend\AuthController@logUserIn')->middleware('guest');
Route::post('register', 'Frontend\AuthController@store');
*/
Route::get('api/login/google', 'Frontend\AuthController@redirectToGoogleProvider');
Route::get('oauth2callback', 'Frontend\AuthController@handleGoogleProviderCallback');
Route::get('login/google', 'Frontend\AuthController@redirectToGoogleProviderWeb');
Route::get('oauth2callback2', 'Frontend\AuthController@handleGoogleProviderCallbackWeb');
Route::get('/api/surveys/login', 'SurveyController@loginGoogle')->middleware('guest');
Route::get('logout', 'Frontend\AuthController@logout')->middleware('auth');

Route::get('surveys', 'Frontend\MainController@surveys')->middleware('auth');
Route::get('surveys/create', 'Frontend\MainController@create')->middleware('auth');
Route::post('surveys/create', 'Frontend\MainController@store')->middleware('auth');
Route::get('surveys/{surveyId}', 'Frontend\MainController@survey')->middleware('auth');
Route::post('surveys/{surveyId}', 'Frontend\MainController@answer')->middleware('auth');
Route::get('surveys/edit/{surveyId}', 'Frontend\MainController@edit')->middleware('auth');
Route::post('surveys/edit/{surveyId}', 'Frontend\MainController@update')->middleware('auth');
Route::get('surveys/delete/{surveyId}', 'Frontend\MainController@delete')->middleware('auth');

Route::resource('/api/surveys', 'SurveyController');

Route::post('/api/surveys/{surveyId}/answer', 'SurveyController@answer');
/*Route::get('surveys/{surveyId}/stats', 'Frontend\MainController@stats');*/