<div style="float:right;">
	<a  class="btn btn-info" href="<?php echo base_url();?>cpurchase/create_purchase_pdf/{purchase_id}">CREATE PDF</a>
	<a  class="btn btn-danger" href="<?php echo base_url();?>cpurchase">CANCEL</a>
</div>
<table class="table">
	<thead>
		<tr>
			<th>&nbsp;</th>
		</tr>
	</thead>
</table>
<div class="well">
	<div style="font-size:22px;font-weight:bold;text-align:center;"><img src="<?php echo base_url(); ?>my-assets/images/logo.gif" height="50" width="100"></div>
	<div style="font-size:20px;font-weight:bold;text-align:center;">Akmatro.com</div>
	<div style="font-size:22px;font-weight:bold;text-align:center;">&nbsp;</div>
	<div style="font-size:20px;font-weight:bold;text-align:center;">Purchase Order</div>
	<div style="font-size:17px;font-weight:bold;">Supplier Name: &nbsp;<span style="font-weight:normal">{supplier_name}</span></div>
</div>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th colspan="3">Date :&nbsp;{final_date}</th>
			<th style="text-align:right" colspan="2">Chalan-No :&nbsp; {chalan_no}</th>
		</tr>
		<tr>
			<th colspan="5">&nbsp;</th>
		</tr>
		<tr>
			<th>#</th>
			<th>Product Name</th>
			<th>Total Quantity</th>
			<th>Rate</th>
			<th>Total Amount</th>
		</tr>
	</thead>
	<tbody>
	{purchase_all_data}
		<tr>
			<td>{sl}</td>
			<td>
				<a href="<?php echo base_url().'cproduct/product_details/{product_id}'; ?>">
				{product_name}
				</a>
			</td>
			<td>{quantity}</td>
			<td>{rate}</td>
			<td>{total_amount}</td>
		</tr>
	{/purchase_all_data}
	</tbody>
	<tfoot>
		<tr>
			<td style="text-align:right" colspan="4"><b>Grand total:</b></td>
			<td class="text-right">{sub_total_amount}</td>
		</tr>
	</tfoot>
</table>
