<?php

namespace Modules\CompanyMarco500\Http\ViewComposers;

use Modules\Dashboard\Services\ViewComposer\ServiceComposer;
use Modules\Subsidiary\Repositories\SubsidiaryRepository;
use Modules\Product\Repositories\ProductRepository;
use Modules\Order\Repositories\ItemRepository;


class ProductsComposer extends ServiceComposer 
{

    private $subsidiary;

    private $selectable_subsidiaries;
    private $products;
    private $total;
    private $date;

    public function assign($view)
    {
        $this->subsidiary($view);
        $this->date($view);
        $this->selectable_subsidiaries();
        $this->products();
    }

    private function subsidiary($view)
    {
        $this->subsidiary = SubsidiaryRepository::loadById($view->subsidiary);
    }

    private function date($view)
    {
        $this->date = $view->date; //request()->date;
    }

    private function selectable_subsidiaries(){
        $this->selectable_subsidiaries = SubsidiaryRepository::loadToSelect('id', 'name');
    }

    private function products()
    {
        $total = 0;
        if($this->subsidiary)
        {
            $products = $this->subsidiary->products;
            foreach ($products as $key => $product) 
            {
                $product->qty = 0;
                $product->total = 0;

                if($this->subsidiary->date)
                {
                    $items = ItemRepository::loadSoldItemsByProductDate($product, $this->date);
                } else 
                {
                    $items = ItemRepository::loadSoldItemsByProduct($product);
                }
                
                foreach ($items as $item) 
                {
                    $product->qty += $item->qty;
                    $product->total += $item->total;
                }

                $total += $product->total;

                if($product->total == 0){
                    $products->forget($key);
                }
            }

            $products = $products->sortByDesc('qty');
        } else {
            $products = [];
        }

        $this->products = $products;
        $this->total = $total;
    }

    public function view($view){
        $view->with('subsidiary', $this->subsidiary);
        $view->with('selectable_subsidiaries', $this->selectable_subsidiaries);
        $view->with('products', $this->products);
        $view->with('total', $this->total);
        $view->with('date', $this->date);
    }

}