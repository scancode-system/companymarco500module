<?php 
namespace Modules\CompanyMarco500\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Modules\Subsidiary\Entities\Subsidiary;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\Saller\Entities\Saller;
use Modules\Order\Entities\Order;

class SallerClientExport implements FromCollection, WithStrictNullComparison, ShouldAutoSize
{

    private $saller;
    private $date;

    private $data;

    public function __construct($saller_id, $date) 
    {
        $this->saller($saller_id);
        $this->date($date);
        $this->data();
    }

    private function saller($saller_id){
        $this->saller = Saller::find($saller_id);
    }

    private function date($date){
        $this->date = $date;
    }

    private function data(){
        $this->data = collect([]);
        $this->data->push(collect([$this->saller->name, $this->date]));

        $orders = Order::loadClosedOrdersBySallerDate($this->saller, $this->date);
        foreach ($orders as $order) {
            $this->data->push(collect([$order->order_client->corporate_name, 'R$ '.number_format($order->total, 2, ',', '.')]));
        }

    }

    public function collection()
    {
        return new Collection($this->data);
    }

}