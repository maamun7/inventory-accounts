<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/customer.js.php" ></script>
<h2>Closing Report</h3>
<script>
    $('.datepicker').datepicker()
    .on(picker_event, function(e){
    # `e` here contains the extra attributes
    });
</script>
<?php $today = date('Y-m-d'); ?>
	<div class="row-fluid">
		<div>
			<form class="well form-inline" method="post" action="<?=base_url()?>cclosing/date_wise_closing_reports">
				<label class="select">Search By Date: From</label>
					<input type="text" name="from_date"  value="<?php echo $today; ?>" data-date-format="yyyy-mm-dd" class="datepicker"/>
				<label class="select">To</label>
					<input type="text" name="to_date" data-date-format="yyyy-mm-dd" class="datepicker"/>
				<button type="submit" class="btn">Search</button>
			</form>
		</div>
	</div>
<?php
if(!empty($daily_closing_data)){
?>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>#</th>
				<th>Date</th>
				<th>Last Day Amount</th>
				<th>Sales In Cheque</th>
				<th>Sales In Cash</th>
				<th>Cheque to Cash</th>
				<th>Expense</th>
				<th>Drawing</th>
				<th>Amount</th>
				<th>Adjusment</th>
			</tr>
		</thead>
		<tbody>
		{daily_closing_data}
			<tr>
				<td>{sl}</td>
				<td>{final_date}</td>
				<td>{last_day_closing}</td>
				<td>{sales_in_cheque}</td>
				<td>{sales_in_cash}</td>
				<td>{cheque_to_cash}</td>
				<td>{expense}</td>
				<td>{drawing}</td>
				<td>{amount}</td>
				<td>{adjusment}</td>
			</tr>
		{/daily_closing_data}
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
