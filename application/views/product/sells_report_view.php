<?php
if(!empty($sales_report)){
?>

<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Date</th>
			<th>Details</th>
			<th>Quantity</th>
			<th>Total Amount</th>
		</tr>
	</thead>
	<tbody>
	{sales_report}
		<tr>
			<td>{sl}</td>
			<td>{final_date}</td>
			<td>
				<a href="<?php echo base_url().'cinvoice/invoice_inserted_data/{invoice_id}'; ?>">Details</a>
			</td>
			<td>{quantity}</td>
			<td>{total_price}</td>
		</tr>
	{/sales_report}
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4" style="text-align:right;"><b>Grand Total</b></td>
			<td><b>{sales_amount}</b></td>
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