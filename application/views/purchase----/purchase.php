<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/supplier.js.php" ></script>
<h2>Purchase list</h3>
<div class="row-fluid">
	<div>
		<form class="well form-inline" method="post" action="<?=base_url()?>cpurchase/purchase_item_by_search">
			<label class="select">Search By Supplier Name : </label>
				<input type="text" name="supplier_name" class="span3 supplierSelection" placeholder='Type Supplier Name' id="supplier_name" >
				<input type="hidden" class="supplier_hidden_value" name="supplier_id" id="suppluerHiddenId"/>
			<button type="submit" class="btn">Search</button>
		</form>
	</div>
</div>

<?php
if(!empty($purchases_list)){
?>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Chalan No</th>
			<th>Supplier Name</th>
			<th>Purchase Date</th>
			<th>Total Amount</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	{purchases_list}
		<tr>
			<td>{sl}</td>
			<td>
				<a href="<?php echo base_url().'cpurchase/purchase_details_data/{purchase_id}'; ?>">
					{chalan_no}
				</a>
			</td>
			<td>
				<a href="<?php echo base_url().'csupplier/supplier_details/{supplier_id}'; ?>">
					{supplier_name}
				</a>
			</td>
			<td>{final_date}</td>
			<td>{grand_total_amount}</td>
			<td>
				<center>
					<a href="<?php echo base_url().'cpurchase/purchase_update_form/{purchase_id}'; ?>"><i title="Edit" class="icon-edit"></i></a>&nbsp; | &nbsp;
					<span class="deletePurchase" name="{purchase_id}"><i class="icon-trash"></i></span>&nbsp; | &nbsp;
					<a  class="btn btn-info" href="<?php echo base_url();?>cpurchase/create_purchase_pdf/{purchase_id}">Download </a>
				</center>
			</td>
		</tr>
	{/purchases_list}
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
