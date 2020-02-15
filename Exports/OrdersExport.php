<?php 
namespace Modules\CompanyMarco500\Exports;

use Modules\Product\Repositories\ProductRepository;
use Modules\Subsidiary\Repositories\SubsidiaryRepository;
use Modules\Order\Repositories\ItemRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Modules\Subsidiary\Entities\Subsidiary;

class OrdersExport implements FromCollection, WithStrictNullComparison
{

    private $total;
    private $subsidiary;


    public function collection()
    {
        return new Collection($this->data());
    }


    private function data(){
    	return array_merge($this->header(), $this->body(), $this->footer());
    }

    private function header(){
    	return [
            ['Filial', 'Total']
        ];
    }

    private function body(){
        $body = [];
        $total = 0;

        $subsidiaries = SubsidiaryRepository::load();

        foreach ($subsidiaries as $subsidiary) {
            $row = (object) [
                'name' => $subsidiary->name,
                'total' => 0
            ];

            $products = $subsidiary->products;
            foreach ($products as $product) {
                $items = ItemRepository::loadSoldItemsByProduct($product); 
                foreach ($items as $item) {
                    $row->total += $item->total;
                }
            }

            $total += $row->total;
            array_push($body, $row);
        }

        $this->total = $total;
        return (new Collection($body))->sortByDesc('total')->toArray();
    }


    private function footer(){
        return [['TOTAL', $this->total]];
    }

}