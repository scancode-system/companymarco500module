<?php


Route::prefix('companymarco500')->group(function() {
    Route::get('/', 'CompanyMarco500Controller@index')->name('companymarco500.index');
    
    Route::get('/orders', 'CompanyMarco500Controller@orders')->name('companymarco500.orders');
    Route::get('/orders/export/{date?}', 'CompanyMarco500Controller@ordersExport')->name('companymarco500.orders.export');

    Route::get('/products', 'CompanyMarco500Controller@products')->name('companymarco500.products');
    Route::get('/products/export/xlsx/{subsidiary}/{date?}', 'CompanyMarco500Controller@productsExport')->name('companymarco500.products.export');
    Route::get('/products/export/pdf/{subsidiary}/{date?}', 'CompanyMarco500Controller@productsExportPdf')->name('companymarco500.products.export.pdf');

});

