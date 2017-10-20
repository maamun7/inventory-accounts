<div style="float:right;">
	<a  class="btn btn-info" href="<?php echo base_url();?>cinvoice/create_invoice_pdf/{invoice_no}/{invoice_id}">CREATE PDF</a>
	<a  class="btn btn-danger" href="<?php echo base_url();?>cinvoice">CANCEL</a>
</div>
<table class="table">
	<thead>
		<tr>
			<th>&nbsp;</th>
		</tr>
	</thead>
</table>
<table class="table table-condensed">
	<thead>
		<tr>
			<th colspan="3"><h3><center><u>Invoice</u></center></h3></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td width="60%">
				<b>{customer_name},</b><br/>
					{customer_address}<br/>
				<b>Phone No:</b> {customer_phone}<br/>
			</td>
			<td width="40%">
				<b>Purchase No:</b> {invoice_no}<br/>
				<b>Date:</b> {final_date}<br/>
			</td>
		</tr>
	</tbody>
</table>
<table border="0" width="97%" style="margin-top:20px;margin-bottom:15px;border-collapse:collapse;">
	<tbody>
		<tr>
			<td> 
			&nbsp;&nbsp;&nbsp; If you have any queries or clarification needed about the commercials please feel free to contact us.
			</td> 
		</tr>
	</tbody>
</table>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Product Name</th>
			<th>Product Model</th>
			<th>Unit Price (Tk.)</th>
			<th>Quantity</th>
			<th>Total Amount</th>
		</tr>
	</thead>
	<tbody>
	{invoice_all_data}
		<tr>
			<td>{sl}</td>
			<td>{product_name}</td>
			<td>{product_model}</td>
			<td>{rate}</td>
			<td>{quantity}</td>
			<td>{total_price}</td>
		</tr>
	{/invoice_all_data}
	</tbody>
	<tfoot>
		<tr>
			<td style="text-align:right" colspan="5"><b>Total :</b></td>
			<td class="text-right">{price_total} Tk.</td>
		</tr>
		<tr>
			<td style="text-align:right" colspan="5"><b>Discount (-):</b></td>
			<td class="text-right">{discount} %</td>
		</tr>
		<tr>
			<td style="text-align:right" colspan="5"><b>Adjustment (-):</b></td>
			<td class="text-right">{adjustment} Tk.</td>
		</tr>
		<tr>
			<td style="text-align:right" colspan="5"><div style="float:left;"><b>In words :</b> <?php echo ucfirst(convert_number_to_words($grand_total)); ?> taka only .</div><b style="text-align:right;">Sub total:</b></td>
			<td class="text-right">{grand_total} Tk.</td>
		</tr>
	</tfoot>
</table>
<table border="0" width="97%" style="margin-top:20px;border-collapse:collapse;">
	<tbody>
		<tr> <td><u><b>Terms & Other Conditions :</b></u></td> </tr>
		<tr> <td>{terms_and_condi}</td> </tr>
		<tr> <td>&nbsp;</td> </tr>
		<tr> <td>Thanking You</td> </tr>
		<tr> <td>&nbsp;</td> </tr>
		<tr> <td>&nbsp;</td> </tr>
		<tr> <td><b>{authorised_p_name}</b></td> </tr>
		<tr> <td>{authorised_p_desg}</td> </tr>
		<tr> <td>Acmatro.com</td> </tr>
		<tr> <td><b>Cell: </b>{authorised_p_cell}</td> </tr>
	</tbody>
</table>