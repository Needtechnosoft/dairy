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

 Route::get('/pass', function () {
     $pass = bcrypt('admin');
     dd($pass);
 });



Route::match(['get', 'post'], 'login', 'AuthController@login')->name('login');
Route::match(['get', 'post'], 'logout', 'AuthController@logout')->name('logout');

Route::group([ 'middleware' => 'role:admin','prefix'=>'admin'],function (){
    Route::get('dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

    // XXX farmer routes
    Route::match(['get', 'post'], 'farmers', 'Admin\FarmerController@addFarmer')->name('admin.farmer');
    Route::get('farmer-list','Admin\FarmerController@listFarmer')->name('list.farmer');
    Route::match(['get', 'post'],'farmer/update','Admin\FarmerController@updateFarmer')->name('update.farmer');
    Route::get('farmer/delete/{id}','Admin\FarmerController@deleteFarmer')->name('delete.farmer');

    Route::get('farmer/detail/{id}','Admin\FarmerController@farmerDetail')->name('farmer.detail');
    Route::post('load-date','Admin\FarmerController@loadDate')->name('farmer.loaddetail');

    // XXX  farmer advance
    Route::get('farmer-advances', 'Admin\AdvanceController@index')->name('admin.farmer.advance');
    Route::post('farmer-advance-add', 'Admin\AdvanceController@addFormerAdvance')->name('admin.farmer.advance.add');
    Route::post('farmer-advance-list', 'Admin\AdvanceController@listFarmerAdvance')->name('admin.farmer.advance.list');
    Route::post('farmer-advance-update', 'Admin\AdvanceController@updateFormerAdvance')->name('admin.farmer.advance.update');
    Route::get('farmer-advance-delete/{id}', 'Admin\AdvanceController@deleteFarmerAdvance');
    Route::post('farmer-advance-list-by-date', 'Admin\AdvanceController@advanceListByDate')->name('admin.advance.list.by.date');



    // XXX collection centers
    Route::get('collection-centers', 'Admin\CenterController@index')->name('admin.collection');
    Route::post('collection-center-add', 'Admin\CenterController@addCollectionCenter')->name('add.center');
    Route::get('collection-center-list', 'Admin\CenterController@listCenter')->name('list.center');
    Route::get('collection-center-delete-{id}', 'Admin\CenterController@deleteCenter')->name('delete.center');
    Route::post('collection-center-update', 'Admin\CenterController@updateCollectionCenter')->name('update.center');

    // XXX milk data
    Route::get('milk-data','Admin\MilkController@index')->name('admin.milk');
    Route::post('milk-data-save/{type}','Admin\MilkController@saveMilkData')->name('store.milk');
    Route::post('milk-data-load','Admin\MilkController@milkDataLoad')->name('load.milk.data');

    // XXX snf and fats
    Route::get('snf-fats','Admin\SnffatController@index')->name('admin.snf.fat');
    Route::post('snf-fats-data','Admin\SnffatController@snffatDataLoad')->name('load.snffat.data');
    Route::post('snf-fats-save','Admin\SnffatController@saveSnffatData')->name('store.snffat');

    // XXX items
    Route::get('items','Admin\ItemController@index')->name('admin.item');
    Route::post('item-add','Admin\ItemController@saveItems')->name('admin.item.save');
    Route::get('item-delete/{id}','Admin\ItemController@deleteItem')->name('admin.item.delete');
    Route::post('item-update','Admin\ItemController@updateItem');

    // XXX sell items
    Route::get('sell-items','Admin\SellitemController@index')->name('admin.sell.item');
    Route::post('sell-item-add','Admin\SellitemController@addSellItem')->name('admin.sell.item.add');
    Route::post('sell-item-list','Admin\SellitemController@sellItemList')->name('admin.sell.item.list');
    Route::post('sell-item-update','Admin\SellitemController@updateSellItem')->name('admin.sell.item.update');
    Route::get('sell-item-delete/{id}', 'Admin\SellitemController@deleteSellitem');



    // XXX  expensess
    Route::get('expenses', 'Admin\ExpenseController@index')->name('admin.exp');
    Route::post('expense-add', 'Admin\ExpenseController@addExpense')->name('admin.exp.add');
    Route::get('expense-list', 'Admin\ExpenseController@listExpense')->name('admin.exp.list');
    Route::get('expense-delete/{id}', 'Admin\ExpenseController@deleteExpense');

    // XXX suppliers
    Route::get('suppliers', 'Admin\SupplierController@index')->name('admin.sup');
    Route::post('add-supplier','Admin\SupplierController@addSupplier')->name('admin.sup.add');
    Route::get('supplier-list', 'Admin\SupplierController@supplierList')->name('admin.sup.list');
    Route::get('supplier-delete/{id}', 'Admin\SupplierController@deleteSupplier');
    Route::post('supplier/update','Admin\SupplierController@updateSupplier');

    // XXX supplier bills

    Route::get('supplier-bills', 'Admin\SupplierController@indexBill')->name('admin.sup.bill');
    Route::post('supplier-bill-add', 'Admin\SupplierController@addBill')->name('admin.sup.bill.add');
    Route::get('supplier-bill-list', 'Admin\SupplierController@listBill')->name('admin.sup.bill.list');
    Route::post('supplier-bill-update', 'Admin\SupplierController@updateBill')->name('admin.sup.bill.update');
    Route::get('supplier-bill-delete/{id}', 'Admin\SupplierController@deleteBill');


    // XXX distributer
    Route::get('distributers', 'Admin\DistributerController@index')->name('admin.dis');
    Route::post('distributer-add', 'Admin\DistributerController@addDistributer')->name('admin.dis.add');
    Route::get('distributer-list', 'Admin\DistributerController@DistributerList')->name('admin.dis.list');
    Route::post('distributer-update', 'Admin\DistributerController@updateDistributer')->name('admin.dis.update');
    Route::get('distributer/delete/{id}', 'Admin\DistributerController@DistributerDelete');

    Route::get('distributer/detail/{id}','Admin\DistributerController@distributerDetail')->name('distributer.detail');
    Route::post('distributer/detail','Admin\DistributerController@distributerDetailLoad')->name('distributer.detail.load');


    // XXX distributer sell
    Route::get('distributer-sells', 'Admin\DistributersellController@index')->name('admin.dis.sell');
    Route::post('distributer-sell-add', 'Admin\DistributersellController@addDistributersell')->name('admin.dis.sell.add');
    Route::post('distributer-sell-list', 'Admin\DistributersellController@listDistributersell')->name('admin.dis.sell.list');
    Route::get('distributer-sell-del/{id}', 'Admin\DistributersellController@deleteDistributersell');




    // XXX XXX employees
    Route::get('employees', 'Admin\EmployeeController@index')->name('admin.emp');
    Route::post('employee-add', 'Admin\EmployeeController@addEmployee')->name('admin.emp.add');
    Route::post('employee/update', 'Admin\EmployeeController@updateEmployee');
    Route::get('employee-list', 'Admin\EmployeeController@employeeList')->name('admin.emp.list');
    Route::get('employee/delete/{id}', 'Admin\EmployeeController@employeeDelete');


});


