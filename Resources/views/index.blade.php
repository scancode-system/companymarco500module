@extends('dashboard::layouts.master')

@section('content')

<div class="card">
	<div class="card-header">
		Opções
	</div>
	<div class="card-body">
		<div class="d-flex mb-3">
			<a href="{{ route('companymarco500.orders') }}" class="btn btn-lg btn-outline-primary flex-fill mr-3">Pedidos</a>
			<a href="{{ route('companymarco500.products') }}" class="btn btn-lg btn-outline-primary flex-fill">Produtos</a>
		</div>
		<div class="d-flex mb-3">
			<a href="{{ route('companymarco500.xlsx.sallerTotals') }}" class="btn btn-lg btn-outline-success flex-fill mr-3">Vendedor - Total de Vendas</a>
		</div>
		<div class="d-flex mb-3">
			<a href="{{ route('companymarco500.saller.client') }}" class="btn btn-lg btn-outline-primary flex-fill mr-3">Vendedor - Cliente</a>
			<a href="{{ route('companymarco500.client') }}" class="btn btn-lg btn-outline-primary flex-fill">Cliente</a>
		</div>
	</div>
</div>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{ route('dashboard') }}">Dashboard</a>
</li>
<li class="breadcrumb-item">
	Marco500
</li>
@endsection
