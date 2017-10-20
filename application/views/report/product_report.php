<h2>Product Sales Report</h3>
<?php $today = date('Y-m-d'); ?>
	<div class="row-fluid">
		<div>
			<form class="well form-inline" method="post" action="<?=base_url()?>creport/product_sales_search_reports">
				<label class="select">Search By Date: From</label>
					<input type="text" name="from_date"  value="<?php echo $today; ?>" data-date-format="yyyy-mm-dd" class="datepicker"/>
				<label class="select">To</label>
					<input type="text" name="to_date" data-date-format="yyyy-mm-dd" class="datepicker" required/>
				<button type="submit" class="btn">Search</button>
			</form>
		</div>
	</div>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th>Sales Date</th>
			<th>Product Name</th>
			<th>Product Model</th>
			<th>Customer Name</th>
			<th>Rate</th>
			<th>Quantity</th>
			<th>Total Amount</th>
		</tr>
	</thead>
	<tbody>
	{product_report}
		<tr>
			<td>{sales_date}</td>
			<td>{product_name}</td>
			<td>{product_model}</td>
			<td>{customer_name}</td>
			<td>{rate}</td>
			<td>{quantity}</td>
			<td>{total_price}</td>
		</tr>
	{/product_report}
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6" class="text-right" style="font-weight:bold;text-align:right;">Grand Total=</td>
			<td><b>{sub_total} Tk.</b></td>
		</tr>
	</tfoot>
</table>

