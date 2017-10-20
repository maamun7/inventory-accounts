<table class="table">
	<thead>
		<tr>
			<th>&nbsp;</th>
		</tr>
	</thead>
</table>
<div class="well">
	<div style="font-size:22px;font-weight:bold;text-align:center;"><img src="<?php echo base_url(); ?>my-assets/images/logo.gif" height="50" width="100"></div>
	<div style="font-size:20px;font-weight:bold;text-align:center;">Akmatro.com</div>
	<div style="font-size:22px;font-weight:bold;text-align:center;">&nbsp;</div>
	<div style="font-size:20px;font-weight:bold;text-align:center;">Purchase Order</div>
	<div style="font-size:17px;font-weight:bold;">Supplier Name: &nbsp;<span style="font-weight:normal">{supplier_name}</span></div>
</div>
<table border="1" width="100%" style="margin-top:25px;border-collapse:collapse;">
	<thead>
		<tr>
			<th colspan="3">Date :&nbsp;{final_date}</th>
			<th style="text-align:right" colspan="2">Chalan-No :&nbsp; {chalan_no}</th>
		</tr>
		<tr>
			<th colspan="5">&nbsp;</th>
		</tr>
		<tr>
			<th>Sl No</th>
			<th>Product Name</th>
			<th>Total Quantity</th>
			<th>Rate</th>
			<th>Total Amount</th>
		</tr>
	</thead>
	<tbody>
	{purchase_all_data}
		<tr>
			<td><center>{sl}</center></td>
			<td><center>{product_name}</center></td>
			<td><center>{quantity}</center></td>
			<td><center>{rate}</center></td>
			<td><center>{total_amount}</center></td>
		</tr>
	{/purchase_all_data}
	</tbody>
	<tfoot>
		<tr>
			<td style="text-align:right" colspan="4"><b>Grand total =</b></td>
			<td class="text-right"><center>{sub_total_amount}</center></td>
		</tr>
	</tfoot>
</table>
