<?php

namespace Modules\CompanyMarco500\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Order\Repositories\OrderRepository;
use  ZipArchive;

class TxtService 
{

	public function run()
	{
		Storage::deleteDirectory('txt');

		$orders = OrderRepository::loadClosedOrders();
		foreach ($orders as $order) {
			foreach ($order->items as $item) {
				
				$file_path = $this->file_path($item);

				if(!Storage::exists($file_path)) 
				{
					$this->header($file_path, $order, $item);
				} 

				$this->item($file_path, $item);
			}
		}

		$this->zip();
		Storage::deleteDirectory('txt');
	}

	private function header($file_path, $order, $item)
	{
		if($order->order_shipping_company->shipping_company_id)
		{
			$shipping_company = $order->order_shipping_company->description;
		} else {
			$shipping_company = '';
		}


		Storage::append($file_path, 
			'*'.
			mb_substr(addString($order->id, 7, '0'), 0, 7) .
			'000' .
			mb_substr(addString($order->order_client->client_id, 7, '0'), 0, 7).
			mb_substr($order->closing_date, 8, 2).
			mb_substr($order->closing_date, 5, 2).
			mb_substr($order->closing_date, 0, 4).
			mb_substr($order->closing_date, 11, 2). 
			mb_substr($order->closing_date, 14, 2).
			mb_substr(addString($order->order_saller->saller_id, 5, '0'), 0, 5).
			mb_substr(addString($order->order_payment->payment_id, 5, '0'), 0, 5).
			mb_substr(addString(number_format($order->order_payment->discount, 2, '', ''), 5, '0'), 0, 5).
			'00000'.
			'00000'.
			'00000'.
			mb_substr(addString($this->subsidiary_id($item), 6, '0'), 0, 6).
			'000'.
			mb_substr(addString($shipping_company, 20, ' ', false), 0, 20).
			'00000000');
	}

	private function item($file_path, $item)
	{
		$tax_ipi = $item->item_taxes()->where('module', 'ipi')->first();
		if($tax_ipi)
		{
			$ipi = $tax_ipi->porcentage;
		}else
		{
			$ipi = 0;
		}

		Storage::append($file_path, 
			mb_substr(addString($item->product->sku, 8, ' ', false), 0, 8). 
			mb_substr(addString($item->qty, 7, '0'), 0, 7). 
			mb_substr(addString(number_format($item->price, 2, '', ''), 7, '0'), 0, 7).
			'00000'.
			mb_substr(addString(number_format($ipi, 2, '', ''), 5, '0'), 0, 5).
			'0');
	}



	public function zip()
	{
		$files = Storage::allFiles('txt');
		$zip_path = storage_path('app/txt.zip'); 
		$zip = new ZipArchive;
		$zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE);
		foreach ($files as $file) {
			$zip->addFile(storage_path('app/'.$file), $file);
		}
		$zip->close();
	}	

	private function file_path($item)
	{
		$product = $item->product;
		$subsidiary_id = $this->subsidiary_id($item);


		if (substr($product->sku, 0, 2) != 'MO') {
			$from = 'importados';
		} else {
			$from = 'nacional';
		}

		return 'txt/filial_'.$subsidiary_id.'/'.$from.'/'.addString($subsidiary_id, 6, '0').'_'.addString($item->order->id, 7, '0') . '.txt';
	}

	private function subsidiary_id($item)
	{
		if($item->product->subsidiaries_product){
			return $item->product->subsidiaries_product->subsidiary_id;
		} else {
			return '';
		}
	}

	public function download()
	{
		return response()->download(storage_path('app/txt.zip'))->deleteFileAfterSend();;
	}

}