<!--<table class="w-100 mb-3">
	<tr>
		<td class="border border-dark height-75 width-130 text-center">
			Total bruto<br>
			@currency($subsidiary->total_gross)
		</td>
		<td class="text-center fs-30">-</td>
		<td class="border border-dark height-75 width-130 text-center">
			Desconto<br>
			@currency($subsidiary->total_discount)
		</td>
		<td class="text-center fs-30">+</td>
		<td class="border border-dark height-75 width-130 text-center">
			Acréscimo<br>
			@currency($subsidiary->total_addition)
		</td>
		<td class="text-center fs-30">+</td>
		<td class="border border-dark height-75 width-130 text-center">
			Impostos<br>
			@currency($subsidiary->total_tax)
		</td>
		<td class="text-center fs-30">=</td>
		<td class="border border-dark height-75 width-130 text-center">
			Total<br>
			@currency($subsidiary->total)
		</td>
	</tr>
</table>-->
<div class="mb-2">
PRAZOS DE PAGAMENTO ESTABELECIDO PELA MARCO500.<br>  CLIENTE NOVO/PRIMEIRA COMPRA 30% DO VALOR ANTECIPADO. <br>ATENÇÃO PARA O VALOR MÍNIMO DE COMPRA.
</div>

<strong>OBSERVAÇÔES:</strong><br>
<table class="w-100">
	<tr>
		<td class="border border-dark p-2" style="height: 150px">
			<p class="p-0 mb-0">{!! nl2br($setting_pdf->global_observation) !!}</p>
			@if(!is_null($order->observation))
			<p class="mb-0 mt-3">{{ $order->observation }}</p>
			@endif
		</td>
	</tr>
</table>
<div>
Estou de acordo com o pedido:<br>
Caso necessário receberei em duas entregas.<br>
**** Os preços acima estão sujeitos a tributação de IPI ****
</div>

<table class="w-100 mt-5">
	<tr>
		<td  class="border-bottom border-dark" style="width: 23%"></td>
		<td></td>
		<td class="border-bottom border-dark" style="width: 23%"></td>
		<td></td>
		<td class="border-bottom border-dark" style="width: 23%"></td>
		<td></td>
		<td class="border-bottom border-dark" style="width: 23%"></td>
	</tr>
	<tr>
		<td>Comprador</td>
		<td></td>
		<td>Assinatura</td>
		<td></td>
		<td>Telefone</td>
		<td></td>
		<td>E-mail</td>
	</tr>
</table>

<!--
<table class="w-100 mb-3">
	<tr>
		<td class="border border-dark p-2">
			<strong>TERMODE RESPONSABILIDADE:</strong><br>
			<p class="mb-0">{!! nl2br($setting_pdf->statement_responsibility) !!}</p>
		</td>
	</tr>
</table>
<p class="text-center fs-20 mb-0">São Paulo, {{ $order->closing_date ?? 'N/A' }}</p>
<p class="text-center fs-15">De acordo:</p>
<table class="w-50 m-auto">
	<tr>
		<td class="border-bottom border-dark height-75">
			@if($order->signature_check)
			<img src="data:image/png;base64, {{ $order->signature }}" width="100%"/>
			@endif
		</td>
	</tr>
</table>-->