<?php
if(!empty($purchase_report)){
?>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Details</th>
			<th>Supplier Name</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
	{purchase_report}
		<tr>
			<td>{sl}</td>
			<td>
				<a href="<?php echo base_url().'cpurchase/purchase_details_data/{purchase_id}'; ?>">
					{chalan_no}
				</a>
			</td>
			<td>{supplier_name}</td>
			<td>{final_total}</td>
		</tr>
	{/purchase_report}
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3" style="text-align:right;font-weight:bold">Grand Total = </td>
			<td><b>{purchase_amount} Tk.</b></td>
		</tr>
	</tfoot>
</table>
<div id="pagin"><center><?php if(isset($links)){echo $links;} ?></center></div>
<?php
}else{
?>
<div class="NoDataFound"><center>No Data Found</center></div>
<?php
}
?>
