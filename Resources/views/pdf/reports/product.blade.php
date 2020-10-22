<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	{{ Html::style('modules/dashboard/coreui/css/style.css') }} 
	{{ Html::style('modules/order/css/pdf.css') }} 
	<style>
		.width-5{width: 5px;}
		.width-10{width: 10px;}
		.width-15{width: 15px;}
		.width-20{width: 20px;}
		.width-75{width: 75px;}
		.width-130{width: 130px;}

		.height-200{height: 200px;}
		.height-50{height: 50px;}
		.height-75{height: 75px;}

		.w-65{width: 65%}

		.fs-15{font-size: 15px;}
		.fs-20{font-size: 20px;}
		.fs-25{font-size: 25px;}
		.fs-30{font-size: 30px;}

		thead{display: table-header-group;}
		tfoot {display: table-row-group;}
		tr {page-break-inside: avoid;}

	</style>
</head>
<body class="bg-white">
	<h3 class="border border-dark text-center p-3">Relatório de produtos da Filial {{ $subsidiary->name }}</h3>
	@if($date)
	<p class="lead">Data: {{ $date }}</p>
	@endif
	<table class="table bg-white border mt-3">
		<thead>
			<tr>
				<th class="align-middle"><span>SKU</span></th>
				<th class="align-middle"><span>Descrição</span></th>
				<th class="align-middle text-center"><span>Preço Base</span></th>
				<th class="align-middle text-center"><span>Quantiade</span></th>
				<th class="align-middle text-center"><span>Total Final</span></th>
			</tr>
		</thead>
		<tbody>
			@foreach($products as $product)
			<tr>
				<td class="align-middle">{{ $product->sku }}</td>
				<td class="align-middle">{{ $product->description }}</td>
				<td class="align-middle text-center">@currency($product->price)</td>
				<td class="align-middle text-center">{{ $product->qty }}</td>
				<td class="align-middle text-center">@currency($product->total)</td>
			</tr>
			@endforeach
			<tr>
				<td class="align-middle" colspan="4"><strong>TOTAL</strong></td>
				<td class="align-middle text-center"><strong>@currency($total)</strong></td>
			</tr>
		</tbody>
	</table>
</body>
</html>