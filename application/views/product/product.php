<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/product.js.php" ></script>
<h2>Product list</h3>
<div class="row-fluid">
	<div>
		<form class="well form-inline" method="post" action="<?=base_url()?>cproduct/product_by_search">
			<label class="select">Search By Product Name : </label>
				<input type="text" name="product_name" onclick="producstList();" class="span3 productSelection" placeholder='Type Product Name' id="product_name" >
				<input type="hidden" class="autocomplete_hidden_value" name="product_id" id="SchoolHiddenId"/>
			<button type="submit" class="btn">Search</button>
		</form>
	</div>
</div>

<?php
if(!empty($products_list)){
?>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Product Name</th>
			<th>Purchase Price</th>
			<th>Quantity Type</th>
			<th>Product Model</th>
			<th><center>Actions</center></th>
		</tr>
	</thead>
	<tbody>
	{products_list}
		<tr>
			<td>{sl}</td>
			<td>
				<a href="<?php echo base_url().'cproduct/product_details/{product_id}'; ?>">
				{product_name}
				</a>			
			</td>
			<td>{purchase_price}</td>
			<td>{quantity_type}</td>
			<td>{product_model}</td>
			<td>
				<center>
					<a href="<?php echo base_url().'cproduct/product_update_form/{product_id}'; ?>"><i title="Edit" class="icon-edit"></i></a>&nbsp; | &nbsp;
					<span class="deleteProduct" name="{product_id}"><i class="icon-trash"></i></span>
				</center>
			</td>
		</tr>
	{/products_list}
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
