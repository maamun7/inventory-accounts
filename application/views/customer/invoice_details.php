<?php
if(!empty($invoice_info)){
?>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th>Date</th>
			<th>Invoice Details</th>		
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
	{invoice_info}
		<tr>
			<td>{final_date}</td>
			<td>
				<a href="<?php echo base_url().'cinvoice/invoice_details/{invoice_id}'; ?>">Details</a>
			</td>
			<td>{total_price}</td>
		</tr>
	{/invoice_info}
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2"><b>Grand Total</b></td>
			<td><b>{invoice_amount}</b></td>
		</tr>
	</tfoot>
</table>
<?php
}else{
?>
<div class="NoDataFound"><center>No Data Found</center></div>
<?php
}
?>