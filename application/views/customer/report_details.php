<?php
if(!empty($receipt_info)){
?>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th>Date</th>
			<th>Receipt Details</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
	{receipt_info}
		<tr>
			<td>{final_date}</td>
			<td>
				<a href="<?php echo base_url().'creceipt/single_receipt/{transaction_id}'; ?>">Details</a>
			</td>
			<td>{amount}</td>
		</tr>
	{/receipt_info}
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2"><b>Grand Total</b></td>
			<td><b>{receipt_amount}</b></td>
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