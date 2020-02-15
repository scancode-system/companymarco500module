<?php

namespace Modules\CompanyMarco500\Http\ViewComposers;

use Modules\Dashboard\Services\ViewComposer\ServiceComposer;
use Modules\Subsidiary\Repositories\SubsidiaryRepository;
use Modules\Product\Repositories\ProductRepository;
use Modules\Order\Repositories\ItemRepository;


class OrdersComposer extends ServiceComposer 
{

    private $subsidiaries;
    private $total;

    public function assign($view)
    {
        $this->subsidiaries();
    }

    private function subsidiaries()
    {
        $subsidiaries = SubsidiaryRepository::load();

        foreach ($subsidiaries as $subsidiary) {
            $subsidiary->total = 0;

            $products = $subsidiary->products;
            foreach ($products as $product) {
                $items = ItemRepository::loadSoldItemsByProduct($product); 
                foreach ($items as $item) {
                    $subsidiary->total += $item->total;
                }
            }
        }

        $this->subsidiaries = $subsidiaries->sortByDesc('total');
    }


    private function products()
    {
        $total = 0;
        if($this->subsidiary)
        {
            $products = $this->subsidiary->products;
            foreach ($products as $product) 
            {
                $product->qty = 0;
                $product->total = 0;

                $items = ItemRepository::loadSoldItemsByProduct($product);
                foreach ($items as $item) 
                {
                    $product->qty += $item->qty;
                    $product->total += $item->total;
                }

                $total += $product->total;
            }

            $products = $products->sortByDesc('total');
        } else {
            $products = [];
        }

        $this->products = $products;
        $this->total = $total;
    }

    public function view($view){
        $view->with('subsidiaries', $this->subsidiaries);
        $view->with('total', $this->total);
    }

}