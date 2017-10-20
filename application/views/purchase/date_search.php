<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/supplier.js.php" ></script>
<h2>Date wise purchases list</h3>
<div class="row-fluid">
	<div class="well form-inline">
		<form class="span5" method="post" action="<?=base_url()?>cpurchase/search_by_supplier">
			<label class="select">Search: </label>
				<input type="text" name="supplier_name" class="span7 supplierSelection" placeholder='Type Supplier Name' id="supplier_name" >
				<input type="hidden" class="supplier_hidden_value" name="supplier_id" id="suppluerHiddenId"/>
			<button type="submit" class="btn">Search</button>
		</form>
		<?php $today = date('Y-m-d'); ?>
		<form class="span7" method="post" action="<?=base_url()?>cpurchase/search_by_date">
			<label class="select">From</label>
				<input type="text" name="from_date" value="<?php echo $today; ?>" data-date-format="yyyy-mm-dd" class="span4 datepicker"/>
			<label class="select">To</label>
				<input type="text" name="to_date" data-date-format="yyyy-mm-dd" class="span4 datepicker"/>
			<button type="submit" class="btn">Search by date</button>
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
			<th>Purchase No</th>
			<th>Supplier Name</th>
			<th>Purchase Date</th>
			<th><center>Total Amount</center></th>
			<th><center>Authorised By</center></th>
			<th><center>Details</center></th>
			<th><center>Download</center></th>
			<th><center>Actions</center></th>
		</tr>
	</thead>
	<tbody>
	{purchases_list}
		<tr>
			<td>{sl}</td>
			<td>{chalan_no}</td>
			<td>
				<a href="<?php echo base_url().'csupplier/supplier_details/{supplier_id}'; ?>">
					{supplier_name}
				</a>
			</td>
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
