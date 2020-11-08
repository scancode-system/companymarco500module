<?php

namespace Modules\CompanyMarco500\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Modules\CompanyMarco500\Http\ViewComposers\ProductsComposer;
use Modules\CompanyMarco500\Http\ViewComposers\OrdersComposer;

use Modules\Subsidiary\Http\ViewComposers\Pdf\OrderComposer;

use Modules\CompanyMarco500\Http\ViewComposers\Xlsx\SallerClientComposer;
use Modules\CompanyMarco500\Http\ViewComposers\Xlsx\ClientComposer;

class ViewComposerServiceProvider extends ServiceProvider 
{

	public function boot() 
	{
		View::composer('companymarco500::products.products', ProductsComposer::class);
		View::composer('companymarco500::orders.orders', OrdersComposer::class);

		// pdf
		View::composer('companymarco500::pdf.order', OrderComposer::class);
		View::composer('companymarco500::pdf.reports.order', OrdersComposer::class);
		View::composer('companymarco500::pdf.reports.product', ProductsComposer::class);

		// xlsx
		View::composer('companymarco500::xlsx.saller_client', SallerClientComposer::class);
	}

	public function register() 
	{
        //
	}

}