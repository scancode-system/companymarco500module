<?php


Route::prefix('companymarco500')->group(function() {
    Route::get('/', 'CompanyMarco500Controller@index')->name('companymarco500.index');
});
