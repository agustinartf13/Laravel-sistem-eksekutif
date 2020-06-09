<?php

// dashboard
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard'));
});


// Home > User+
Breadcrumbs::for('user', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('User', route('admin.user.index'));
});

// Dashboard > Supplier
Breadcrumbs::for('supplierAdmin', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Supplier', route('admin.supplier.index'));
});
Breadcrumbs::for('supplierOperator', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Supplier', route('operator.supplier.index'));
});
Breadcrumbs::for('supptoplevel', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Supplier', route('toplevel.supplier.index'));
});


// Dashboard > Motor
Breadcrumbs::for('motorAdmin', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Motor', route('admin.motor.index'));
});
Breadcrumbs::for('motorOperator', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Motor', route('operator.motor.index'));
});
Breadcrumbs::for('motorToplevel', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Motor', route('toplevel.motor.index'));
});


// Dashboard > mekanik
Breadcrumbs::for('mekanikAdmin', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('mekanik', route('admin.mekanik.index'));
});
Breadcrumbs::for('mekanikOperator', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('mekanik', route('operator.mekanik.index'));
});
Breadcrumbs::for('mekanikToplevel', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('mekanik', route('toplevel.mekanik.index'));
});


// Dashboard > barang
Breadcrumbs::for('barangAdmin', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('barang', route('admin.barang.index'));
});
Breadcrumbs::for('barangOperator', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('barang', route('operator.barang.index'));
});
Breadcrumbs::for('barangToplevel', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('barang', route('toplevel.barang.index'));
});


// Dashboard > categories
Breadcrumbs::for('categoriesAdmin', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('categories', route('admin.categories.index'));
});
Breadcrumbs::for('categoriesOperator', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('categories', route('operator.categories.index'));
});
Breadcrumbs::for('categoriesToplevel', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('categories', route('toplevel.categories.index'));
});


// Dashboard > penjualan
Breadcrumbs::for('penjualanAdmin', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('penjualan', route('admin.penjualan.index'));
});

Breadcrumbs::for('penjualanOperator', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('penjualan', route('operator.penjualan.index'));
});
Breadcrumbs::for('penjualanToplevel', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('penjualan', route('toplevel.penjualan.index'));
});



// Dashboard > service
Breadcrumbs::for('serviceAdmin', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Service', route('admin.servis.index'));
});
Breadcrumbs::for('serviceOperator', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Service', route('operator.servis.index'));
});


// Dashboard > pembelian
Breadcrumbs::for('pembelianAdmin', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('pembelian', route('admin.pembelian.index'));
});

Breadcrumbs::for('pembelianOperator', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('pembelian', route('operator.pembelian.index'));
});
Breadcrumbs::for('pembelianToplevel', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('pembelian', route('toplevel.pembelian.index'));
});


Breadcrumbs::for('persediaanAdmin', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Persediaan', route('admin.persediaan'));
});

Breadcrumbs::for('persediaanToplevel', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Persediaan', route('toplevel.persediaan'));
});

Breadcrumbs::for('persediaanOperator', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Persediaan', route('operator.persediaan'));
});

