<?php
if(!empty($sales_report)){
?>

<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Details</th>
			<th>Customer Name</th>
			<th>Total Amount</th>
		</tr>
	</thead>
	<tbody>
	{sales_report}
		<tr>
			<td>{sl}</td>
			<td>
				<a href="<?php echo base_url().'cinvoice/invoice_inserted_data/{invoice_id}'; ?>">Details</a>
			</td>
			<td>{customer_name}</td>
			<td>{final_total}</td>
		</tr>
	{/sales_report}
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3" style="text-align:right;"><b>Grand Total</b></td>
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