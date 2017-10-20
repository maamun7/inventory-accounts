<table class="table">
	<thead>
		<tr>
			<th>&nbsp;</th>
		</tr>
	</thead>
</table>
<table width="100%" style="margin-top:45px;border-collapse:collapse;">
	<thead>
		<tr>
			<th colspan="3"><h2><center><u>Invoice </u></center></h2></th>
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
				<b>Date:</b> {final_date}<br/><br/>
			</td>
		</tr>
	</tbody>
</table>
<table border="1" width="100%" style="text-align:center;margin-top:25px;border-collapse:collapse;">
	<thead>
		<tr>
			<th>#</th>
			<th>Product Name</th>
			<th>Unit Price(Tk)</th>
			<th>Quantity</th>
			<th>Total Amount</th>
		</tr>
	</thead>
	<tbody>
	{invoice_all_data}
		<tr>
			<td>{sl}</td>
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
			<td style="text-align:right" colspan="5"><b style="text-align:right;">Sub total:</b></td>
			<td class="text-right">{grand_total} Tk.</td>
		</tr>
	</tfoot>
</table>
<table style="margin-top:2px;border-collapse:collapse;">
	<tbody> <tr> <td><div style="float:left;"><b>In words :</b> <?php echo ucfirst(convert_number_to_words($grand_total)); ?> taka only .</div></td> </tr> </tbody>
</table>
<table border="0" width="97%" style="margin-top:20px;margin-bottom:15px;border-collapse:collapse;">
	<tbody>
		<tr>
			<td> 
			&nbsp;&nbsp;&nbsp;  If you have any queries or clarification needed about the commercials please feel free to contact us.
			</td> 
		</tr>
	</tbody>
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