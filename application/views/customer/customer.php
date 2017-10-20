<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/customer.js.php" ></script>
<h2>Customer list</h3>
<div class="row-fluid">
	<div>
		<form class="well form-inline" method="post" action="<?=base_url()?>ccustomer/customer_search_item">
			<label class="select">Search By Customer Name : </label>
				<input type="text" name="customer_name" class="span3 customerSelection" placeholder='Type Customer Name' id="customer_name" >
				<input type="hidden" class="customer_hidden_value" name="customer_id" id="SchoolHiddenId"/>
			<button type="submit" class="btn">Search</button>
		</form>
	</div>
</div>
<?php
if(!empty($customers_list)){
?>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Customer Name</th>
			<th>Address</th>
			<th>Mobile</th>
			<th>Email</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
	{customers_list}
		<tr>
			<td>{sl}</td>
			<td>
				<a href="<?php echo base_url().'ccustomer/customer_ledger/{customer_id}'; ?>">{customer_name}</a>				
			</td>
			<td>{customer_address}</td>
			<td>{customer_mobile}</td>
			<td>{customer_email}</td>
			<td>
				<center>
					<a href="<?php echo base_url().'ccustomer/customer_update_form/{customer_id}'; ?>"><i title="Edit" class="icon-edit"></i></a>&nbsp; | &nbsp;
					<span class="deleteCustomer" name="{customer_id}"><i class="icon-trash"></i></span>
				</center>
			</td>
		</tr>
	{/customers_list}
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
