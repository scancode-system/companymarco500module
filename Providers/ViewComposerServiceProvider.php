<?php

namespace Modules\CompanyMarco500\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Modules\CompanyMarco500\Http\ViewComposers\ProductsComposer;
use Modules\CompanyMarco500\Http\ViewComposers\OrdersComposer;

class ViewComposerServiceProvider extends ServiceProvider 
{

	public function boot() 
	{
		View::composer('companymarco500::products.products', ProductsComposer::class);
		View::composer('companymarco500::orders.orders', OrdersComposer::class);
	}

	public function register() 
	{
        //
	}

}
