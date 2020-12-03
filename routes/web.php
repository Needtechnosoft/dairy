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


Route::get('/','HomeController@home');

// Route::get('/pass', function () {
//     $pass = bcrypt('admin');
//     dd($pass);
// });




Route::match(['get', 'post'], 'login', 'AuthController@login')->name('login');
Route::match(['get', 'post'], 'logout', 'AuthController@logout')->name('logout');

Route::group([ 'middleware' => 'role:admin','prefix'=>'admin'],function (){
    Route::get('dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
    
    // farmer routes
    Route::match(['get', 'post'], 'farmers', 'Admin\FarmerController@addFarmer')->name('add.farmer');
    Route::get('farmer-list','Admin\FarmerController@listFarmer')->name('list.farmer');
    Route::match(['get', 'post'],'farmer/update','Admin\FarmerController@updateFarmer')->name('update.farmer');
    Route::get('farmer/delete/{id}','Admin\FarmerController@deleteFarmer')->name('delete.farmer');

    // collection centers
    Route::get('collection-centers', 'Admin\CenterController@index')->name('admin.collection');
    Route::post('collection-center-add', 'Admin\CenterController@addCollectionCenter')->name('add.center');
    Route::get('collection-center-list', 'Admin\CenterController@listCenter')->name('list.center');
    Route::get('collection-center-delete-{id}', 'Admin\CenterController@deleteCenter')->name('delete.center');
    Route::post('collection-center-update', 'Admin\CenterController@updateCollectionCenter')->name('update.center');
    
    // milk data
    Route::get('milk-data','Admin\MilkController@index')->name('admin.milk');
    Route::post('milk-data-save/{type}','Admin\MilkController@saveMilkData')->name('store.milk');
    Route::post('milk-data-load','Admin\MilkController@milkDataLoad')->name('load.milk.data');

    // snf and fats
    Route::get('snf-fats','Admin\SnffatController@index')->name('admin.snf.fat');
    Route::post('snf-fats-data','Admin\SnffatController@snffatDataLoad')->name('load.snffat.data');
    Route::post('snf-fats-save','Admin\SnffatController@saveSnffatData')->name('store.snffat');


});