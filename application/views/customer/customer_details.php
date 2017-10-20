<div class="well span7" style="margin-left:0px !important;width:96.4% !important">
	<div class="" style="float:left;height:120px;width:30%;">
		<h2>{customer_name}</h2>
		<h4>{customer_email}</h4>
		<h4>{customer_mobile}</h4>
	</div>
	<div class="" style="float:right;height:70px;width:30%;">
		<table class="table table-striped table-condensed table-bordered">
			<tr>	
				<td style="text-align:right;font-weight:bold">Total Invoice =</td>
				<td>{invoice_amount} /=</td>
			</tr>
			<tr>	
				<td style="text-align:right;font-weight:bold">Total Receipt =</td>
				<td>{receipt_amount} /=</td>
			</tr>
			<tr>	
				<td style="text-align:right;font-weight:bold">Status =</td>
				<td style="color:#{color};">{status_amount} <?php if($status_amount != ""){?>/=<?php };?> ({payment_status})</td>
			</tr>
		</table>
	</div>
</div>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th><center><h5>Sales Report</h5></center></th>
			<th><center><h5>Receipt Report</h5></center></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<div style="width:100%">	
					{invoice_info}
				</div>
			</td>
			<td>
				<div style="width:100%">	
					{receipt_info}
				</div>
			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
	</tfoot>
</table>