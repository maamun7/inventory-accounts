<?php
if(!empty($sales_report)){
?>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Details</th>
			<th>Customer Name</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
	{sales_report}
		<tr>
			<td>{sl}</td>
			<td>
				<a href="<?php echo base_url().'cinvoice/invoice_details/{invoice_id}'; ?>">
					{invoice_no}
				</a>
			</td>
			<td>{customer_name}</td>
			<td>{final_total}</td>
		</tr>
	{/sales_report}
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3" style="text-align:right;font-weight:bold">Grand Total = </td>
			<td><b>{sales_amount} Tk.</b></td>
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