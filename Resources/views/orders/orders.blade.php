@extends('dashboard::layouts.master')

@section('content')

<div class="card">
	<div class="card-header">
		Pedidos
	</div>
	<div class="card-body">
		{{ Form::open(['route' => 'companymarco500.orders', 'method' => 'GET']) }}
		<div class="d-flex">
			{{ Form::date('date', $date, ['class' => 'form-control']) }}
			{{ Form::button('Filtrar', ['type' => 'submit', 'class' => 'btn btn-primary ml-3']) }}
		</div>
		{{ Form::close() }}

		{{ Form::open(['route' => ['companymarco500.orders.export', $date], 'method' => 'GET']) }}
		{{ Form::button('<i class="fa fa-file-excel-o"></i> Relatório', ['type' => 'submit', 'class' => 'btn btn-outline-success']) }}
		{{ Form::close() }}

		<table class="table table-responsive-sm bg-white table-hover border mt-3">
			@include('companymarco500::orders.tables.thead')
			<tbody>
				@each('companymarco500::orders.tables.tr', $subsidiaries, 'subsidiary')
				<tr>
					<td class="align-middle"><strong>Total</strong></td>
					<td class="align-middle text-center"><strong>@currency($total)</strong></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{ route('dashboard') }}">Dashboard</a>
</li>
<li class="breadcrumb-item">
	<a href="{{ route('companymarco500.index') }}">Marco500</a>
</li>
<li class="breadcrumb-item">
	Pedidos
</li>
@endsection
