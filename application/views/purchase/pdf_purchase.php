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
			<th colspan="3"><h3><center><u>Purchase Order </u></center></h3></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td width="60%">
				<b>{supplier_name},</b><br/>
					{supplier_address}<br/>
				<b>Phone No:</b> {supplier_phone}<br/>
			</td>
			<td width="40%">
				<b>Purchase No:</b> {chalan_no}<br/>
				<b>Date:</b> {final_date}<br/>
				<b>Requested By:</b> {requested_p_name}<br/>
			</td>
		</tr>
	</tbody>
</table>
<table border="1" width="100%" style="margin-top:25px;border-collapse:collapse;">
	<thead>
		<tr>
			<th>Job Description</th>
			<th>Bill To</th>
			<th>Ship To</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td width="30%">{job_description}</td>
			<td width="30%">
				<b>Akmatro.com</b><br/>
				Dhaka Trade Center(15<sup>th</sup> Floor),<br/>
				99 Kazi Nazrul Islam Avenue,<br/>
				Dhaka-1205
			</td>
			<td width="30%">{ship_to}</td>
		</tr>
	</tbody>
</table>
<table border="0" width="97%" style="margin-top:20px;margin-bottom:15px;border-collapse:collapse;">
	<tbody>
		<tr>
			<td> 
			&nbsp;&nbsp;&nbsp; We are much pleased to forward the below products.Please deliver these products as soon as possible as per our requirements.
			</td> 
		</tr>
	</tbody>
</table>
<table border="1" width="100%" style="text-align:center;margin-top:25px;border-collapse:collapse;">
	<thead>
		<tr>
			<th>#</th>
			<th>Product Name</th>
			<th>Product Model</th>
			<th>Unit Price</th>
			<th>Quantity</th>
			<th>Total Amount</th>
		</tr>
	</thead>
	<tbody>
	{purchase_all_data}
		<tr>
			<td>{sl}</td>
			<td>{product_name}</td>
			<td>{product_model}</td>
			<td>{rate}</td>
			<td>{quantity}</td>
			<td>{total_amount}</td>
		</tr>
	{/purchase_all_data}
	</tbody>
	<tfoot>
		<tr>
			<td style="text-align:right" colspan="5"><b>Total :</b></td>
			<td class="text-right">{total_price} Tk.</td>
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