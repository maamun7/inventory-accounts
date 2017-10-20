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
			<th>#</th>
			<th>Purchase No</th>
			<th>Purchase Date</th>
			<th><center>Total Amount</center></th>
			<th><center>Authorised By</center></th>
			<th><center>Details</center></th>
			<th><center>Download</center></th>
			<th><center>Actions</center></th>
		</tr>
	</thead>
	<tbody>
	{purchase_info}
		<tr>
			<td>{sl}</td>
			<td>{chalan_no}</td>
			<td>{final_date}</td><?php //echo date_numeric_format("{purchase_date}"); ?>
			<td><center>{final_total} Tk.</center></td>
			<td><center>{authorised_p_name}</center></td>
			<td>
				<center><a href="<?php echo base_url().'cpurchase/purchase_details_data/{purchase_id}'; ?>">View </a></center>
			</td>
			<td>
				<center>
					<a  class="btn" href="<?php echo base_url();?>cpurchase/create_purchase_pdf/{purchase_id}"><i title="Download" class="icon-download"></i> </a>
				</center>
			</td>
			<td>
				<center>
					<a href="<?php echo base_url().'cpurchase/edit_purchase/{purchase_id}'; ?>"><i title="Edit" class="icon-edit"></i></a>&nbsp; | &nbsp;
					<span class="deletePurchase" name="{purchase_id}"><i title="Delete" class="icon-trash"></i></span>
				</center>
			</td>
		</tr>
	{/purchase_info}
	</tbody>
</table>
<div id="pagin"><center><?php if(isset($links)){echo $links;} ?></center></div>
<?php
}else{
?>
<div class="NoDataFound"><center>No Data Found</center></div>
<?php
}
?>
