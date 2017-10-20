<div class="well span7" style="margin-left:0px !important;width:96.4% !important">
		<h2>{supplier_name}</h2>
		<h4>{supplier_mobile}</h4>
		<h5>{supplier_address}</h5>
</div>
<h4>Purchase Report</h4>
<?php
if(!empty($purchase_info)){
?>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th>Date</th>
			<th>Chalan No</th>
			<th>Details</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
	{purchase_info}
		<tr>
			<td>{final_date}</td>
			<td>
				<a href="<?php echo base_url().'cpurchase/purchase_details_data/{purchase_id}'; ?>">
					{chalan_no}
				</a>
			</td>
			<td>{purchase_details}</td>
			<td>{grand_total_amount}</td>
		</tr>
	{/purchase_info}
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td><b>{total_amount}</b></td>
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
