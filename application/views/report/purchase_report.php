<?php
if(!empty($purchase_report)){
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
	{purchase_report}
		<tr>
			<td>{sl}</td>
			<td>{final_date}</td>
			<td>
				<a href="<?php echo base_url().'cpurchase/purchase_details_data/{purchase_id}'; ?>">
					{chalan_no}
				</a>
			</td>
			<td>{quantity}</td>
			<td>{total_amount}</td>
		</tr>
	{/purchase_report}
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4" style="text-align:right;"><b>Grand Total</b></td>
			<td><b>{purchase_amount}</b></td>
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
