@extends('dashboard::layouts.master')

@section('content')

<div class="card">
	<div class="card-header">
		Pedidos
	</div>
	<div class="card-body">
		{{ Form::open(['route' => 'companymarco500.orders', 'method' => 'GET']) }}
		<div class="d-flex">
			<fieldset class="form-group m-0">
				<div class="input-group">
					<span class="input-group-prepend">
						<span class="input-group-text">
							<i class="fa fa-calendar"></i>
						</span>
					</span>
					{{ Form::text('start_end_date', $start_end_date , ['class' => 'form-control']) }}
				</div>
			</fieldset>
			{{ Form::button('<i class="fa fa-filter"></i>', ['type' => 'submit', 'class' => 'btn btn-primary mx-3', 'name' => 'action', 'value' => 'web']) }}
			{{ Form::button('<i class="fa fa-file-excel-o"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-success', 'name' => 'action', 'value' => 'excel']) }}
		</div>
		<!--<div class="d-flex">
			{{ Form::date('date', /*$date*/ null, ['class' => 'form-control']) }}
			{{ Form::button('Filtrar', ['type' => 'submit', 'class' => 'btn btn-primary ml-3']) }}
		</div>-->
		{{ Form::close() }}

<!--
		{{ Form::open(['route' => ['companymarco500.orders.export', /*$date*/ null], 'method' => 'GET']) }}
		{{ Form::button('<i class="fa fa-file-excel-o"></i> Relatório', ['type' => 'submit', 'class' => 'btn btn-outline-success']) }}
		{{ Form::close() }}
	-->

	<table class="table table-responsive-sm bg-white table-hover border mt-3">
		@include('companymarco500::orders.tables.thead')
		<tbody>
			@foreach($subsidiaries as $subsidiary)
			<tr>
				<td class="align-middle">{{ $subsidiary->name }}</td>
				@foreach($dates as $date)
				<td class="align-middle">@currency($subsidiary->$date)</td>
				@endforeach
				<td class="align-middle text-center">@currency($subsidiary->total)</td>
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


@push('styles')
{{ Html::style('modules/dashboard/coreui/vendors/bootstrap-daterangepicker/css/daterangepicker.min.css') }} 
@endpush


@push('scripts')
{{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js') }}
{{ Html::script('modules/dashboard/coreui/node_modules/bootstrap-daterangepicker/daterangepicker.js') }}

<script>
	$('input[name="start_end_date"]').daterangepicker({
		opens: 'left',
		locale: {
			format: 'D/M/Y'
		},
		ranges: {
			Today: [moment(), moment()],
			Yesterday: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		}
	});

</script>

@endpush