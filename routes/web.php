<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/features', function () {
    return view('features');
});

// Route::get('/pricing', function () {
//     return view('pricing');
// });

Auth::routes(['verify' => true]);

//Admin
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('contacts', 'ContactController');
    Route::resource('configurations', 'ConfigurationController');
    Route::resource('stores', 'StoreController');
    Route::resource('categories', 'CategoryController');
    Route::resource('projects', 'ProjectController');
    Route::resource('documents', 'DocumentController');
    Route::resource('tasks', 'TaskController');
    Route::resource('comments', 'CommentController');
    Route::resource('efforts', 'EffortController');
    Route::resource('billings', 'BillingController');
    Route::resource('environments', 'EnvironmentController');
    Route::resource('projectenvironments', 'ProjectEnvironmentController');
    Route::resource('alertnotifications', 'AlertNotificationController');

    //Payment Test
    Route::get('/payment', 'PaymentController@index');
    Route::post('/payment', 'PaymentController@payment')->name('payment');

    //My profile
    Route::get('/myprofile', 'MyProfileController@show')->name('myprofile');
    Route::patch('/myprofile', 'MyProfileController@update')->name('saveprofile');

    //Account Setting
    Route::get('/accountsetting', 'AccountSettingController@show')->name('accountsetting');
    Route::patch('/accountsetting', 'AccountSettingController@update')->name('saveaccountsetting');

    Route::get('/alertnotifications', 'AlertNotificationController@index')->name('alertnotifications');
});


