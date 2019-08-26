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

/**
 * Unauthorised pages
 */
Route::get('/', 'WelcomeController@index')->name('welcome');

/**
 * Magic auth routes
 */
Auth::routes();

/**
 * Routes that require authentication
 */
Route::group(['middleware' => ['auth']], function() {
    /**
     * Static pages
     */
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/admin', 'AdminDashboardController@index')->name('admin');

    /**
     * Resources
     */
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('role_types', 'RoleTypeController');
    Route::resource('role_competencies', 'RoleCompetencyController');
    Route::resource('powered_locomotives', 'PoweredLocomotiveController');
    Route::resource('steam_locomotives', 'SteamLocomotiveController');
});
