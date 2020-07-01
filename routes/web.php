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
    Route::get("/show/data", 'DashboardController@showData')->name('show.data');

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
    Route::get("/barang/exportpdfbarang", "BarangController@exportPdf")->name("barang.exportpdfbarang");
    Route::get("/barang/exportexcelbarang", "BarangController@exportExcel")->name("barang.exportexcelbarang");
    Route::resource('barang', 'BarangController');

    Route::get("/supplier/{id}/set-status", "SupplierController@setStatus")->name("supplier.status");
    Route::get("/api/supplier", "SupplierController@apisupplier")->name("api.supplier");
    Route::resource('supplier', 'SupplierController');

    Route::get('persediaan', "PersediaanController@index")->name('persediaan');
    Route::get("/api/persediaan", "PersediaanController@apipersediaan")->name("api.persediaan");

    Route::get('peramalan', "PeramalanController@index")->name('peramalan');

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
    Route::get('/laporan/salepermonthbeli', 'LaporanPembelianController@totalSalePerMonth')->name("laporan.salepermonthbeli");
    Route::get("/laporan/pembelian/exportexcel", "LaporanPembelianController@exportExcel")->name("laporan.exportexcel");
    Route::get("/laporan/pembelian/exportpdfpembelian", "LaporanPembelianController@exportPdf")->name("laporan.exportpdfpembelian");
    Route::get("/api/beli", "LaporanPembelianController@apibeli")->name("api.beli");

    Route::get("/laporan/penjualan", "LaporanPenjualanController@laporanJual")->name("laporan.jual");
    Route::get('/laporan/salepermonth', 'LaporanPenjualanController@totalSalePerMonth')->name("laporan.salepermonth");
    Route::get("/laporan/penjualan/exportexcel", "LaporanPenjualanController@exportExcel")->name("laporan.exportexcel");
    Route::get("/laporan/penjualan/exportpdfpenjualan", "LaporanPenjualanController@exportPdf")->name("laporan.exportpdfpenjualan");
    Route::get("/api/jual", "LaporanPenjualanController@apijual")->name("api.jual");

    Route::get("/laporan/service", "LaporanServiceController@laporanService")->name("laporan.service");
    Route::get("/laporan/service/exportexcel", "LaporanServiceController@exportExcel")->name("laporan.exportexcel");
    Route::get('/laporan/salepermonthservice', 'LaporanServiceController@totalSalePerMonth')->name("laporan.salepermonthservice");
    Route::get("/laporan/service/exportpdfservice", "LaporanServiceController@exportPdf")->name("laporan.exportpdfservice");
    Route::get("/api/service", "LaporanServiceController@apiservice")->name("api.service");

});

# route toplevel group
Route::group(['as' => 'toplevel.', 'prefix' => 'toplevel', 'namespace' => 'Toplevel', 'middleware' => ['auth', 'toplevel']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get("/show/data", 'DashboardController@showData')->name('show.data');

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

    Route::get('persediaan', "PersediaanController@index")->name('persediaan');
    Route::get("/persediaan/exportpdfbarang", "PersediaanController@exportPdf")->name("persediaan.exportpdfbarang");
    Route::get("/persediaan/exportexcelbarang", "PersediaanController@exportExcel")->name("persediaan.exportexcelbarang");
    Route::get("/api/persediaan", "PersediaanController@apipersediaan")->name("api.persediaan");

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

    Route::get('peramalan', "PeramalanController@index")->name('peramalan');

    Route::get("/laporan/pembelian", "LaporanPembelianController@laporanBeli")->name("laporan.beli");
    Route::get('/laporan/salepermonthbeli', 'LaporanPembelianController@totalSalePerMonth')->name("laporan.salepermonthbeli");
    Route::get("/laporan/pembelian/exportexcelpembelian", "LaporanPembelianController@exportExcel")->name("laporan.exportexcelpembelian");
    Route::get("/laporan/pembelian/exportpdfpembelian", "LaporanPembelianController@exportPdf")->name("laporan.exportpdfpembelian");
    Route::get("/api/beli", "LaporanPembelianController@apibeli")->name("api.beli");

    Route::get("/laporan/penjualan", "LaporanPenjualanController@laporanJual")->name("laporan.jual");
    Route::get('/laporan/salepermonthjual', 'LaporanPenjualanController@totalSalePerMonth')->name("laporan.salepermonthjual");
    Route::get("/laporan/penjualan/exportexcelpenjualan", "LaporanPenjualanController@exportExcel")->name("laporan.exportexcelpenjualan");
    Route::get("/laporan/penjualan/exportpdfpenjualan", "LaporanPenjualanController@exportPdf")->name("laporan.exportpdfpenjualan");
    Route::get("/api/jual", "LaporanPenjualanController@apijual")->name("api.jual");

    Route::get("/laporan/service", "LaporanServiceController@laporanService")->name("laporan.service");
    Route::get('/laporan/salepermonthservice', 'LaporanServiceController@totalSalePerMonth')->name("laporan.salepermonthservice");
    Route::get("/laporan/service/exportexcelservice", "LaporanServiceController@exportExcel")->name("laporan.exportexcelservice");
    Route::get("/laporan/service/exportpdfservice", "LaporanServiceController@exportPdf")->name("laporan.exportpdfservice");
    Route::get("/api/service", "LaporanServiceController@apiservice")->name("api.service");

});

# route operator group
Route::group(['as' => 'operator.', 'prefix' => 'operator', 'namespace' => 'Operator', 'middleware' => ['auth', 'operator']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

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

    Route::get('persediaan', "PersediaanController@index")->name('persediaan');
    Route::get("/persediaan/exportpdfbarang", "PersediaanController@exportPdf")->name("persediaan.exportpdfbarang");
    Route::get("/persediaan/exportexcelbarang", "PersediaanController@exportExcel")->name("persediaan.exportexcelbarang");
    Route::get("/api/persediaan", "PersediaanController@apipersediaan")->name("api.persediaan");

    Route::get("/supplier/{id}/set-status", "SupplierController@setStatus")->name("supplier.status");
    Route::get("/api/supplier", "SupplierController@apisupplier")->name("api.supplier");
    Route::resource('supplier', 'SupplierController');

    Route::get("/penjualan/{id}/invoice", "PenjualanController@invoice")->name("penjualan.invoice");
    Route::get("/api/penjualan", "PenjualanController@apipenjualan")->name("api.penjualan");
    Route::get("/penjualan/exportexcelpenjualan", "PenjualanController@exportExcel")->name("penjualan.exportexcelpenjualan");
    Route::get("/penjualan/exportpdfpenjualan", "PenjualanController@exportPdf")->name("penjualan.exportpdfpenjualan");
    Route::resource('penjualan', 'PenjualanController');

    Route::get("/servis/{id}/set-status", "ServiceController@setStatus")->name("servis.status");
    Route::get("/servis/{id}/invoice", "ServiceController@invoice")->name("servis.invoice");
    Route::get("/api/servis", "ServiceController@apiservis")->name("api.servis");
    Route::get("/servis/exportexcel", "ServiceController@exportExcel")->name("servis.exportexcelservis");
    Route::get("/servis/exportpdfservice", "ServiceController@exportPdf")->name("servis.exportpdfservis");
    Route::resource('servis', 'ServiceController');
});
