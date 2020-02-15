<?php 
namespace Modules\CompanyMarco500\Exports;

use Modules\Product\Repositories\ProductRepository;
use Modules\Order\Repositories\ItemRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Modules\Subsidiary\Entities\Subsidiary;

class ProductsExport implements FromCollection, WithStrictNullComparison
{

    private $total;
    private $subsidiary;

    public function __construct(Subsidiary $subsidiary) 
    {
        $this->subsidiary = $subsidiary;
    }

    public function collection()
    {
        return new Collection($this->data());
    }


    private function data(){
    	return array_merge($this->header(), $this->body(), $this->footer());
    }

    private function header(){
    	return [
            [$this->subsidiary->name],
            ['SKU', 'Descrição', 'Preço Base', 'Quantidade', 'Total']
        ];
    }

    private function body(){
        $body = [];
        $total = 0;
        $products = $this->subsidiary->products;

        foreach ($products as $product) 
        {
            $row = (object) [
                'sku' => $product->sku,
                'description' => $product->description,
                'price' => $product->price,
                'qty' => 0,
                'total' => 0
            ];

            $product->qty = 0;
            $product->total = 0;

            $items = ItemRepository::loadSoldItemsByProduct($product);
            foreach ($items as $item) 
            {
                $row->qty += $item->qty;
                $row->total += $item->total;
            }

            $total += $row->total;
            array_push($body, $row);
        }

        $this->total = $total;
        return (new Collection($body))->sortByDesc('total')->toArray();

    }


    private function footer(){
        return [['TOTAL', '', '', '', $this->total]];
    }

}