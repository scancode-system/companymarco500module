@extends('dashboard::layouts.master')

@section('content')

<div class="card">
	<div class="card-header">
		Produtos
	</div>
	<div class="card-body">
		<div class="d-flex">
			{{ Form::model($subsidiary, ['route' => 'companymarco500.products', 'method' => 'GET']) }}
			<div class="d-flex">
				{{ Form::select('id', $selectable_subsidiaries, null, ['class' => 'form-control', 'placeholder' => 'Todas as Filiais']) }}
				{{ Form::date('date', null, ['class' => 'form-control ml-3']) }}
				{{ Form::button('Filtrar', ['type' => 'submit', 'class' => 'btn btn-primary ml-3']) }}

			</div>
			{{ Form::close() }}

			@if($subsidiary)
			{{ Form::open(['route' => ['companymarco500.products.export', $subsidiary, $subsidiary->date], 'method' => 'GET', ]) }}
			{{ Form::button('<i class="fa fa-file-excel-o"></i> Relatório', ['type' => 'submit', 'class' => 'btn btn-outline-success ml-3']) }}
			{{ Form::close() }}
			@else
			{{ Form::button('<i class="fa fa-file-excel-o"></i> Relatório', ['type' => 'submit', 'class' => 'btn btn-outline-success ml-3', 'disabled' => 'disabled']) }}
			@endif

		</div>

		<table class="table table-responsive-sm bg-white table-hover border mt-3">
			@include('companymarco500::products.tables.thead')
			<tbody>
				@each('companymarco500::products.tables.tr', $products, 'product')
				<tr>
					<td class="align-middle" colspan="4"><strong>TOTAL</strong></td>
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
	Produtos
</li>
@endsection
