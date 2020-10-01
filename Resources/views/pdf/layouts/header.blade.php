<div class="text-center">
	{{ $company->company_address->street ?? 'N/A' }} 
	{{ $company->company_address->number ?? 'N/A' }} - 
	{{ $company->company_address->neighborhood ?? 'N/A' }} - 
	{{ $company->company_address->st ?? 'N/A' }}<br>
	{{ $company->company_info->phone ?? 'N/A' }} - 
	{{ $company->company_info->email ?? 'N/A' }}
</div>
<hr>
<table class="border border-dark w-100">
	<tr>
		<td class="p-3">Número do pedido:<br>{{ $order->id }}</td>
		<td class="p-3">Representante:<br>{{ $order->order_saller->name }}</td>
		<td class="p-3">Data:<br>{{ $order->closing_date->format('d/m/Y H:i') }}</td>
	</tr>
</table>


<table class="w-100">
	<tr>
		<td>{{ $setting_pdf->title }}</td>
		<td class="text-right">Pedido: {{ $order->id }}</td>
	</tr>
</table>

<h3 class="m-0 text-center mb-2">Cliente</h3>
<table class="border border-dark w-100 mb-3">
	<tr>
		<td class="p-3">
			<div>
				<strong>Código:</strong><br>
				{{ $order->order_client->client_id ?? 'N/A' }}
			</div>
			<div>
				<strong>Logradouro:</strong><br>
				{{ $order->order_client->order_client_address->street ?? 'N/A' }}
			</div>
			<div>
				<strong>UF:</strong><br>
				{{ $order->order_client->order_client_address->st ?? 'N/A' }}
			</div>
			<div>
				<strong>Telefone:</strong><br>
				{{ $order->order_client->phone  ?? 'N/A' }}
			</div>
			<div>
				<strong>CPF/CNPJ:</strong><br>
				{{ $order->order_client->cpf_cnpj ?? 'N/A' }}
			</div>
		</td>
		<td class="p-3">
			<div>
				<strong>Nome Fantaisa:</strong><br>
				{{ $order->order_client->fantasy_name ?? 'N/A' }}
			</div>
			<div>
				<strong>Bairro:</strong><br>
				{{ $order->order_client->order_client_address->neighborhood ?? 'N/A' }}
			</div>
			<div>
				<strong>CEP:</strong><br>
				{{ $order->order_client->order_client_address->postcode ?? 'N/A' }}
			</div>
			<div>
				<strong>Telefone 2:</strong><br>
				{{ 'N/A' }}
			</div>
			<div>
				<strong>Transportadora:</strong><br>
				{{ $order->order_shipping_company->description ?? 'N/A'  }}
			</div>
		</td>
		<td class="p-3">
			<div>
				<strong>Razão Social:</strong><br>
				{{ $order->order_client->corporate_name ?? 'N/A' }}
			</div>
			<div>
				<strong>Cidade:</strong><br>
				{{ $order->order_client->order_client_address->city ?? 'N/A' }}
			</div>
			<div>
				<strong>Inscrição Estadual:</strong><br>
				{{ 'N/A' }}
			</div>
			<div>
				<strong>Email:</strong><br>
				{{ $order->order_client->email ?? 'N/A' }}
			</div>
		</td>
	</tr>
</table>

<!--<table class="w-100 mb-3">
	<tr>
		<td class="border border-dark">
			<p class="border-bottom border-dark p-1 mb-0" >Representante</p>
			<table class="w-100 m-2">
				<tr>
					<td><strong>Codigo: </strong>{{ $order->saller_id }}</td>
					<td><strong>Nome: </strong>{{ $order->order_saller->name }}</td>
					<td><strong>Email: </strong>{{ $order->order_saller->email }}</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table class="w-100 mb-3">
	<tr>
		<td class="border border-dark">
			<p class="border-bottom border-dark p-1 mb-0" >Detalhes do Pedido</p>
			<table class="w-100 m-2">
				<tr>
					<td><strong>Pagamento: </strong>{{ $order->order_payment->description }}</td>
					<td><strong>Transportadora: </strong>{{ $order->order_shipping_company->description }}</td>
					<td><strong>Entrega: </strong>{{ $order->delivery_name }}</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

-->