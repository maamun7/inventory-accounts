<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/supplier.js.php" ></script>
<h2>Supplier list</h3>
<div class="row-fluid">
	<div>
		<form class="well form-inline" method="post" action="<?=base_url()?>csupplier/supplier_search_item">
			<label class="select">Search By Supplier Name : </label>
				<input type="text" name="supplier_name" class="span3 supplierSelection" placeholder='Type Supplier Name' id="supplier_name" >
				<input type="hidden" class="supplier_hidden_value" name="supplier_id" id="suppluerHiddenId"/>
			<button type="submit" class="btn">Search</button>
		</form>
	</div>
</div>
<?php
if(!empty($suppliers_list)){
?>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Supplier Name</th>
			<th>Address</th>
			<th>Mobile</th>
			<th>Details</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	{suppliers_list}
		<tr>
			<td>{sl}</td>
			<td>
				<a href="<?php echo base_url().'csupplier/supplier_details/{supplier_id}'; ?>">
					{supplier_name}
				</a>
			</td>
			<td>{address}</td>
			<td>{mobile}</td>
			<td>{details}</td>
			<td>
				<center>
					<a href="<?php echo base_url().'csupplier/supplier_update_form/{supplier_id}'; ?>"><i title="Edit" class="icon-edit"></i></a>&nbsp; | &nbsp;
					<span class="deleteSupplier" name="{supplier_id}"><i class="icon-trash"></i></span>
				</center>
			</td>
		</tr>
	{/suppliers_list}
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