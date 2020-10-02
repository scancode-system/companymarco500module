<?php

namespace Modules\CompanyMarco500\Http\ViewComposers;

use Modules\Dashboard\Services\ViewComposer\ServiceComposer;
use Modules\Subsidiary\Repositories\SubsidiaryRepository;
use Modules\Product\Repositories\ProductRepository;
use Modules\Order\Repositories\ItemRepository;
use Modules\Order\Repositories\OrderRepository;
use Modules\Order\Entities\Order;


class OrdersComposer extends ServiceComposer 
{

    private $start;
    private $end;

    private $subsidiaries;
    protected $dates;
    private $total;

    public function assign($view)
    {
        $this->start($view);
        $this->end($view);
        $this->dates();
        $this->total();
        $this->subsidiaries();
    }

    private function start($view)
    {
        $this->start = $view->start;
    }

    private function end($view)
    {
        $this->end = $view->end;
    }

    private function dates()
    {
        $this->dates = OrderRepository::loadClosingDatesBetweenClosingDates($this->start, $this->end);
    }

    private function total()
    {
        $this->total = 0;
    }

    private function subsidiaries()
    {
        $subsidiaries = SubsidiaryRepository::load();

        foreach ($subsidiaries as $subsidiary) {
            $subsidiary->total = 0;
            foreach ($this->dates as $date) {
                $subsidiary->$date = 0;
            }

            $products = $subsidiary->products;
            foreach ($products as $product) {
                $items = ItemRepository::loadSoldItemsByProduct($product);
                if($items->count() > 0){
                    $date = $items->first()->order->closing_date->format('Y-m-d');
                    if($this->dates->contains($date)){
                    foreach ($items as $item) {
                        $subsidiary->total += $item->total;
                        $subsidiary->{$date} += $item->total;
                    }
                }
                }
            }
            $this->total += $subsidiary->total;
        }

        $this->subsidiaries = $subsidiaries->sortByDesc('total');
    }


    public function view($view){
        $view->with('subsidiaries', $this->subsidiaries);
        $view->with('dates', $this->dates);
        $view->with('total', $this->total);
    }

}