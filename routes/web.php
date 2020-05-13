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



Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

# route admin group
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::get("/api/user", "UserController@apiuser")->name("api.user");
    Route::resource('user', 'UserController');

    Route::get("/api/motor", "MotorController@apimotor")->name("api.motor");
    Route::get("/motor/{id}/edit", "MotorController@edit")->name("motor.edit");
    Route::post("/motor/update", "MotorController@update")->name("motor.update");
    Route::resource('motor', 'MotorController');

    Route::get("/mekanik/{id}/set-status", "MekanikController@setStatus")->name("mekanik.status");
    Route::get("/api/mekanik", "MekanikController@apimekanik")->name("api.mekanik");
    Route::resource('mekanik', 'MekanikController');

    Route::get("/api/categories", "CategoryController@apicategories")->name("api.categories");
    Route::get("/categories/{id}/edit", "CategoryController@edit")->name("categories.edit");
    Route::resource('categories', 'CategoryController');

    Route::get("/api/barang", "BarangController@apibarang")->name("api.barang");
    Route::resource('barang', 'BarangController');

    Route::get("/supplier/{id}/set-status", "SupplierController@setStatus")->name("supplier.status");
    Route::get("/api/supplier", "SupplierController@apisupplier")->name("api.supplier");
    Route::resource('supplier', 'SupplierController');

    Route::get("/pembelian/{id}/set-status", "PembelianController@setStatus")->name("pembelian.status");
    Route::get("/pembelian/{id}/invoice", "PembelianController@invoice")->name("pembelian.invoice");
    Route::get("/pembelian/{id}/invoice-print", "PembelianController@invoicePrint")->name("pembelian.invoiceprint");
    Route::get("/api/pembelian", "PembelianController@apipembelian")->name("api.pembelian");
    Route::resource('pembelian', 'PembelianController');

    Route::get("/penjualan/{id}/invoice", "PenjualanController@invoice")->name("penjualan.invoice");
    Route::get("/api/penjualan", "PenjualanController@apipenjualan")->name("api.penjualan");
    Route::resource('penjualan', 'PenjualanController');

    Route::get("/servis/{id}/set-status", "ServiceController@setStatus")->name("servis.status");
    Route::get("/servis/{id}/invoice", "ServiceController@invoice")->name("servis.invoice");
    Route::get("/api/servis", "ServiceController@apiservis")->name("api.servis");
    Route::resource('servis', 'ServiceController');


    Route::get("/laporan/pembelian", "LaporanPembelianController@laporanBeli")->name("laporan.beli");
    
    Route::get("/laporan/penjualan", "LaporanPenjualanController@laporanJual")->name("laporan.jual");

    Route::get("/laporan/service", "LaporanServiceController@laporanService")->name("laporan.service");

});

# route toplevel group
Route::group(['as' => 'toplevel.', 'prefix' => 'toplevel', 'namespace' => 'Toplevel', 'middleware' => ['auth', 'toplevel']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
});

# route operator group
Route::group(['as' => 'operator.', 'prefix' => 'operator', 'namespace' => 'Operator', 'middleware' => ['auth', 'operator']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
});