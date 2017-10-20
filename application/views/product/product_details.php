<div class="well span7" style="margin-left:0px !important;width:96.4% !important">
	<h2> <span style="font-weight:normal;">Name: </span><span style="color:#005580;">{product_name}</span></h2>
	<h4> <span style="font-weight:normal;">Model:</span> <span style="color:#005580;">{product_model}</span></h4>
	<h4> <span style="font-weight:normal;">Price:</span> <span style="color:#005580;">{purchase_price}</span></h4>
	
	<table class="table">
		<tr>
			<th>Total Purchase = <span style="color:#ff0000;">{total_purchase}</span> <span style="color:#000;font-size:11px;">{quantity_type}</span></th>
			<th>Total Sales = <span style="color:#ff0000;">{total_sales} <span style="color:#000;font-size:11px;">{quantity_type}</span></span></th>
			<th>Stock = <span style="color:#ff0000;">{stock} </span> <span style="color:#000;font-size:11px;">{quantity_type}</span></th>
		</tr>
	</table>
</div>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th><center><h5>Purchase Report</h5></center></th>
			<th><center><h5>Sales Report</h5></center></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<div style="width:100%">	
					{purchase_content}
				</div>
			</td>
			<td>
				<div style="width:100%">	
					{sales_content}
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