<tr>
	<td class="align-middle">{{ $product->sku }}</td>
	<td class="align-middle">{{ $product->description }}</td>
	<td class="align-middle text-center">@currency($product->price)</td>
	<td class="align-middle text-center">{{ $product->qty }}</td>
	<td class="align-middle text-center">@currency($product->total)</td>
</tr>