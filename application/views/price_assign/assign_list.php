<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/customer.js.php" ></script>
<h2>Price List For Customer</h3>
<div class="row-fluid">
	<div>
		<form class="well form-inline" method="post" action="<?=base_url()?>cprice_assign/customer_search_item">
			<label class="select">Search By Customer Name : </label>
				<input type="text" name="customer_name" class="span3 customerSelection" placeholder='Type Customer Name' id="customer_name" >
				<input type="hidden" class="customer_hidden_value" name="customer_id" id="SchoolHiddenId"/>
			<button type="submit" class="btn">Search</button>
		</form>
	</div>
</div>
<?php
if(!empty($customer_price_list)){
?>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Customer Name</th>
			<th>Product Name</th>
			<th>Model No</th>
			<th>Price</th>
		</tr>
	</thead>
	<tbody>
	{customer_price_list}
		<tr>
			<td>{sl}</td>
			<td>
				<a href="<?php echo base_url().'ccustomer/customer_ledger/{customer_id}'; ?>">{customer_name}</a>				
			</td>
			<td>{product_name}</td>
			<td>{product_model}</td>
			<td>{price}</td>
		</tr>
	{/customer_price_list}
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
