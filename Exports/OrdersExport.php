<?php 
namespace Modules\CompanyMarco500\Exports;

use Modules\Product\Repositories\ProductRepository;
use Modules\Subsidiary\Repositories\SubsidiaryRepository;
use Modules\Order\Repositories\ItemRepository;
use Modules\Order\Repositories\OrderRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Modules\Subsidiary\Entities\Subsidiary;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrdersExport implements FromCollection, WithStrictNullComparison, ShouldAutoSize
{

    private $dates;
    private $data;

    private $total;


    public function __construct($start, $end) 
    {
                $this->data();
        $this->dates($start, $end);
        $this->header();
        $this->body();
        $this->footer();
    }

    private function data(){
        $this->data = collect([]);
    }

    private function dates($start, $end){
         $this->dates = OrderRepository::loadClosingDatesBetweenClosingDates($start, $end);
    }

    private function header(){
        $this->data->push(
            collect(['Filial'])->merge(
                $this->dates
            )->merge(
                collect(['Total'])
            ));
    }

    private function body(){
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
                }
                if($this->dates->contains($date)){
                    foreach ($items as $item) {
                        $subsidiary->total += $item->total;
                        $subsidiary->{$date} += $item->total;
                    }
                }
            }
            $this->total += $subsidiary->total;
        }

        $subsidiaries = $subsidiaries->sortByDesc('total');

        foreach ($subsidiaries as $subsidiary) {

            $row = collect([]);
            $row->push($subsidiary->name);
            foreach ($this->dates as $date) {
                $row->push('R$'.number_format($subsidiary->{$date}, 2, ',', '.'));
            }
            $row->push('R$'.number_format($subsidiary->total, 2, ',', '.'));
             $this->data->push($row);
        }
    }

    private function footer(){
        $footer =  collect(['TOTAL']);
        foreach ($this->dates as $date) {
                $footer->push('');
        }
        $footer->push('R$'.number_format($this->total, 2, ',', '.'));
        $this->data->push($footer);
    }


    public function collection()
    {
        return new Collection($this->data);
    }

}