<?php

namespace Modules\CompanyMarco500\Http\ViewComposers;

use stdClass;
use Modules\Order\Entities\Order;
use Modules\Order\Repositories\ItemRepository;
use Modules\Order\Repositories\OrderRepository;
use Modules\Product\Repositories\ProductRepository;
use Modules\Subsidiary\Repositories\SubsidiaryRepository;
use Modules\Dashboard\Services\ViewComposer\ServiceComposer;


class OrdersComposer extends ServiceComposer 
{

    private $start;
    private $end;
    private $order;

    private $subsidiaries;
    protected $dates;
    private $total;
    private $total_dates;

    public function assign($view)
    {
        $this->start($view);
        $this->end($view);
        $this->order($view);
        $this->dates();
        $this->total();
        $this->total_dates();
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

    private function order($view)
    {
        $this->order = $view->order;
    }    

    private function dates()
    {
        $this->dates = OrderRepository::loadClosingDatesBetweenClosingDates($this->start, $this->end);
    }

    private function total()
    {
        $this->total = 0;
    }

    private function total_dates()
    {
        $this->total_dates = new stdClass();
        foreach ($this->dates as $date) {
            $this->total_dates->{$date} = 0;
        }

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
                        foreach ($items as $item) {
                            $date = $item->order->closing_date->format('Y-m-d');
                            if($this->dates->contains($date)){
                                $subsidiary->total += $item->total;
                                $subsidiary->{$date} += $item->total;
                                $this->total_dates->{$date} += $item->total;
                            }
                        }
                }
            }
            $this->total += $subsidiary->total;
        }

        if($this->order == 'name'){
            $this->subsidiaries = $subsidiaries->sortBy($this->order);
        } else {
            $this->subsidiaries = $subsidiaries->sortByDesc($this->order);
        }
    }


    public function view($view){
        $view->with('subsidiaries', $this->subsidiaries);
        $view->with('dates', $this->dates);
        $view->with('total', $this->total);
        $view->with('total_dates', $this->total_dates);
    }

}