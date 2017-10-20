<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/product.js.php" ></script>
<h2>Stock list</h3>
	<div class="row-fluid">
		<div>
			<form class="well form-inline" method="post" action="<?=base_url()?>creport/stock_report_by_search">
				<label class="select">Search By Product:</label>
					<input type="text" name="product_name" onclick="producstList();" class="span3 productSelection" placeholder='Type Product Name' id="product_name" >
					<input type="hidden" class="autocomplete_hidden_value" name="product_id" id="SchoolHiddenId"/>
				<button type="submit" class="btn">Search</button>
			</form>
		</div>
	</div>
<?php
if(!empty($stok_report)){
?>	
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Product Name</th>
			<th>Product Model</th>			
			<th>Purchase Quantity</th>
			<th>Sales Quantity</th>
			<th>Stock Quantity</th>
			<th>Purchase Price</th>
		</tr>
	</thead>
	<tbody>
	{stok_report}
		<tr>
			<td>{sl}</td>
			<td>
				<a href="<?php echo base_url().'cproduct/product_details/{product_id}'; ?>">
				{product_name}
				</a>	
			</td>
			<td>{product_model}</td>
			<td>{purchase_quantity}</td>
			<td>{sales_quantity}</td>
			<td>{stok_quantity}</td>
			<td>{purchase_price}</td>
		</tr>
	{/stok_report}
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