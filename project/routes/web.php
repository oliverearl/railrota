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
     * Additional non-CRUD Operations Routes
     * Turns out these need to be before resources
     * https://stackoverflow.com/questions/16661292/add-new-methods-to-a-resource-controller-in-laravel
     *
     */
    Route::get('/operations/glance', 'OperationController@glance')->name('operations.glance');
    Route::get('/operations/calendar', 'OperationController@glance')->name('operations.calendar');
    Route::get('/operations/pdf', 'OperationController@pdf')->name('operations.pdf');
    Route::patch('/operations/{operation}/shifts/{shift}/register', 'OperationShiftController@register')->name('operations.shifts.register');
    Route::patch('/operations/{operation}/shifts/{shift}/deregister', 'OperationShiftController@deregister')->name('operations.shifts.deregister');

    /**
     * Resources
     */
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('role_types', 'RoleTypeController');
    Route::resource('role_competencies', 'RoleCompetencyController');
    Route::resource('powered_locomotives', 'PoweredLocomotiveController');
    Route::resource('steam_locomotives', 'SteamLocomotiveController');
    Route::resource('locations', 'LocationController');
    Route::resource('operations', 'OperationController');
    Route::resource('operations.shifts', 'OperationShiftController');


});
