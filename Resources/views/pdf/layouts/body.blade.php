<table class="w-100 mb-3">
	@include('companymarco500::pdf.tables.thead')
	<tbody>
		@foreach($subsidiary->items as $item)
		<tr>
			<td class="border-bottom border-dark p-2 border-left">{{ $item->item_product->sku }}</td>
			<td class="border-bottom border-dark p-2">
				{{ $item->item_product->description }}
				<small class="text-info">{{ $item->observation }}</small>
			</td>
			<td class="border-bottom border-dark text-center p-2">{{ $item->qty }}</td>
			<td class="border-bottom border-dark text-center p-2">@currency($item->price_net)</td>
			<td class="border-bottom border-right border-dark text-center p-2 border-right">@currency($item->total)</td>
		</tr> 
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<td class="border-bottom border-dark p-2 border-left"><strong>Total</strong></td>
			<td class="border-bottom border-dark p-2"></td>
			<td class="border-bottom border-dark p-2"></td>
			<td class="border-bottom border-dark p-2"></td>
			<td class="border-bottom border-right border-dark text-center p-2 border-right"><strong>@currency($subsidiary->total)</strong></td>
		</tr>
	</tfoot>
</table>