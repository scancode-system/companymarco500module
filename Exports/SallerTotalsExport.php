<?php 
namespace Modules\CompanyMarco500\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Modules\Subsidiary\Entities\Subsidiary;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\Order\Entities\Order;
use Modules\Saller\Entities\Saller;

class SallerTotalsExport implements FromCollection, WithStrictNullComparison, ShouldAutoSize
{

    private $dates;
    private $data;
    private $totals;

    public function __construct() 
    {
        $this->data();
        $this->dates();
        $this->totals();
        $this->header();
        $this->body();
        $this->footer();
    }

    private function data(){
        $this->data = collect([]);
    }

    public function dates(){
        $this->dates = Order::allClosingDates();
    }

    public function totals(){
        $row =  collect([]);
        foreach ($this->dates as $carbon_date) {
            $row->put($carbon_date->format('m/d'), 0);
        }
        $row->put('total', 0);
        $this->totals = $row;
    }

    private function header(){
        $dates = collect(['']);
        foreach ($this->dates as $carbon_date) {
            $dates->push($carbon_date->format('m/d'));
        }
        $dates->push('Total');
        $this->data->push($dates);
    }

    private function body(){
        $sallers = Saller::all();
        foreach ($sallers as $saller) {
            foreach ($this->dates as $carbon_date) {
                $saller->{$carbon_date->format('m/d')} = 0;
            }
            $saller->total = 0;
        }

        foreach (Order::closedOrders() as $order) {
            foreach ($sallers as $saller) {
                if($saller->id == $order->order_saller->saller_id){
                    $saller->{$order->closing_date->format('m/d')}  += $order->total;
                    $saller->total += $order->total;
                }
            }
            $this->totals[$order->closing_date->format('m/d')] += $order->total;
            $this->totals['total'] += $order->total;
        }

        foreach ($sallers as $saller) {
            $row = collect([$saller->name]);
            foreach ($this->dates as $carbon_date) {
                $row->push(number_format($saller->{$carbon_date->format('m/d')}, 2, ',', '.'));
            }
            $row->push(number_format($saller->total, 2, ',', '.'));
            $this->data->push($row);
        }
        
    }

    private function footer(){
        $row = collect(['Total']);
        foreach ($this->dates as $carbon_date) {
            $row->push(number_format( $this->totals[$carbon_date->format('m/d')] , 2, ',', '.'));
        }
        $row->push(number_format( $this->totals['total'] , 2, ',', '.'));
        $this->data->push($row);
    }


    public function collection()
    {
        return new Collection($this->data);
    }

}