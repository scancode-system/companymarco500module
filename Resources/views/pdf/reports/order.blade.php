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
	<h1 class="border border-dark text-center">Relatório de vendas por Filial</h1>
	<table class="border border-dark" style="width: 100%;">
		<thead>
			<tr>
				<th class="align-middle border-bottom border-dark "><span>Filial</span></th>
				@foreach($dates as $date)
				<th class="align-middle border-bottom border-dark"><span>{{ $date }}</span></th>
				@endforeach
				<th class="align-middle text-center border-bottom border-dark"><span>Total</span></th>
			</tr>
		</thead>
		<tbody>
			@foreach($subsidiaries as $subsidiary)
			<tr>
				<td class="align-middle border-bottom border-dark">{{ $subsidiary->name }}</td>
				@foreach($dates as $date)
				<td class="align-middle border-bottom border-dark">@currency($subsidiary->$date)</td>
				@endforeach
				<td class="align-middle text-center border-bottom border-dark">@currency($subsidiary->total)</td>
			</tr>
			@endforeach
			<tr>
				<td class="align-middle"><strong>Total</strong></td>
				@foreach($dates as $date)
				<td></td>
				@endforeach
				<td class="align-middle text-center"><strong>@currency($total)</strong></td>
			</tr>
		</tbody>
	</table>
</body>
</html>
