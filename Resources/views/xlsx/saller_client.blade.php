@extends('dashboard::layouts.master') 

@section('content')
@alert_errors()
<div class="card">
	<div class="card-header">
		Vendedor - Cliente
	</div>
	<div class="card-body">
		<div class="d-flex">
			{{ Form::open(['route' => 'companymarco500.xlsx.sallerClient', 'method' => 'GET']) }}
			<div class="d-flex">
				{{ Form::select('saller_id', $sallers, null, ['class' => 'form-control']) }}
				{{ Form::date('date', null, ['class' => 'form-control ml-3']) }}
				{{ Form::button('<i class="fa fa-file-excel-o"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-success ml-3']) }}
			</div>
			{{ Form::close() }}
		</div>
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
	Verdendor- Cliente
</li>
@endsection
