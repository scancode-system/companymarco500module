<thead>
	<tr>
		<th class="align-middle"><span>Filial</span></th>
		@foreach($dates as $date)
		<th class="align-middle"><span>{{ $date }}</span></th>
		@endforeach
		<th class="align-middle text-center"><span>Total</span></th>
	</tr>
</thead>