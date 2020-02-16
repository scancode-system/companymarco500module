<?php

namespace Modules\CompanyMarco500\Http\ViewComposers;

use Modules\Dashboard\Services\ViewComposer\ServiceComposer;
use Modules\Subsidiary\Repositories\SubsidiaryRepository;
use Modules\Product\Repositories\ProductRepository;
use Modules\Order\Repositories\ItemRepository;


class OrdersComposer extends ServiceComposer 
{

    private $date;
    private $subsidiaries;
    private $total;

    public function assign($view)
    {
        $this->date();
        $this->subsidiaries();
    }


    private function date()
    {
        $this->date = request()->date;
    }


    private function subsidiaries()
    {
        $subsidiaries = SubsidiaryRepository::load();

        foreach ($subsidiaries as $subsidiary) {
            $subsidiary->total = 0;

            $products = $subsidiary->products;
            foreach ($products as $product) {

                if($this->date)
                {
                    $items = ItemRepository::loadSoldItemsByProductDate($product, $this->date);
                } else 
                {
                    $items = ItemRepository::loadSoldItemsByProduct($product);
                }
                foreach ($items as $item) {
                    $subsidiary->total += $item->total;
                }
            }
        }

        $this->subsidiaries = $subsidiaries->sortByDesc('total');
    }


    public function view($view){
        $view->with('subsidiaries', $this->subsidiaries);
        $view->with('total', $this->total);
        $view->with('date', $this->date);
    }

}