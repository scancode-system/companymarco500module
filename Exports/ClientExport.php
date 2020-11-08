<?php 
namespace Modules\CompanyMarco500\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Modules\Subsidiary\Entities\Subsidiary;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Modules\Saller\Entities\Saller;
use Modules\Order\Entities\Order;

class ClientExport implements FromCollection, WithStrictNullComparison, ShouldAutoSize
{

    private $date;
    private $data;

    public function __construct($date) 
    {
        $this->date($date);
        $this->data();
    }


    private function date($date){
        $this->date = $date;
    }

    private function data(){
        $this->data = collect([]);
        $this->data->push(collect([$this->date]));
        $this->data->push(collect(['CLIENTE', 'CIDADE', 'ESTADO', 'VENDEDOR', 'TOTAL']));

        $orders =  Order::closedOrdersDate($this->date);

        foreach ($orders as $order) {
            $this->data->push([
                $order->order_client->corporate_name,
                $order->order_client->order_client_address->city,
                $order->order_client->order_client_address->st,
                $order->order_saller->name, 
                number_format($order->total , 2, ',', '.')
            ]);
        }

    }

    public function collection()
    {
        return new Collection($this->data);
    }

}