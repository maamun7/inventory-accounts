<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/customer.js.php" ></script>
<h2>Invoice list</h3>
<div class="row-fluid">
	<div class="well form-inline">
		<form class="span5" method="post" action="<?=base_url()?>cinvoice/search_by_customer">
			<label class="select">Search: </label>
				<input type="text" name="customer_name" class="span7 customerSelection" placeholder='Type Customer Name' id="customer_name" >
				<input type="hidden" class="customer_hidden_value" name="customer_id" id="SchoolHiddenId"/>
			<button type="submit" class="btn">Search</button>
		</form>
		<?php $today = date('Y-m-d'); ?>
		<form class="span7" method="post" action="<?=base_url()?>cinvoice/search_by_date">
			<label class="select">From</label>
				<input type="text" name="from_date" value="<?php echo $today; ?>" data-date-format="yyyy-mm-dd" class="span4 datepicker"/>
			<label class="select">To</label>
				<input type="text" name="to_date" data-date-format="yyyy-mm-dd" class="span4 datepicker"/>
			<button type="submit" class="btn">Search by date</button>
		</form>
	</div>
</div>
<?php
if(!empty($invoice_list)){
?>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Date</th>
			<th>Invoice No</th>
			<th>Customer Name</th>
			<th>Authorised By</th>
			<th>Total Amount</th>
			<th>Detalis</th>
			<th><center>Download</center></th>
			<th><center>Actions</center></th>
		</tr>
	</thead>
	<tbody>
	{invoice_list}
		<tr>
			<td>{sl}</td>
			<td>{final_date}</td>
			<td> {invoice_no}</td>
			<td>
				<a href="<?php echo base_url().'ccustomer/customer_ledger/{customer_id}'; ?>">{customer_name}</a>				
			</td>
			<td> {authorised_p_name}</td>
			<td>{final_total} Tk.</td>
			<td>
				<a href="<?php echo base_url().'cinvoice/invoice_details/{invoice_id}'; ?>">View</a>
			</td>
			<td>
				<center>
					<a  class="btn btn-info" href="<?php echo base_url();?>cinvoice/create_invoice_pdf/{invoice_no}/{invoice_id}"><i title="Download" class="icon-download"></i></a>
				</center>
			</td>
			<td>
				<center>
					<a href="<?php echo base_url().'cinvoice/edit_invoice/{invoice_id}'; ?>"><i title="Edit" class="icon-edit"></i></a>&nbsp; | &nbsp;
					<span class="deleteInvoice" name="{invoice_id}"><i class="icon-trash"></i></span>
				</center>
			</td>
		</tr>
	{/invoice_list}
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