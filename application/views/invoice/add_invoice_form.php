<h2>New invoice</h2>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/all_form_validation.js" ></script>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/product_invoice.js.php" ></script>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/customer.js.php" ></script>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/invoice.js" type="text/javascript"></script>
<div class="form-container">
    <form class="form-vertical" action="<?=base_url()?>cinvoice/add_invoice" id="invoice" method="post"  name="insert_invoice" enctype="multypart/formdata">
        <legend>Invoice detail</legend>
		<div class="row-fluid">
			<div class="span4">
				<?php $date = date('Y-m-d'); ?>
            	<div class="control-group">
                    <label class="control-label">Date</label>
                    <div class="controls">
                        <input type="text" tabindex="1" class="span12" name="created_on" value="<?php echo date_numeric_format($date); ?>" required />
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label" for="created_by">Authorised By</label>
                    <div class="controls">
						<select name="authorised_by_id" class="span12" id="authorised_by_id" tabindex="2" >
							<option selected="selected" value="">..Select Authorised Person..</option> 
							{auth_person_list}
								<option value="{id}">{name}</option>  
							{/auth_person_list}
						</select>
					</div>
                </div>
				<div class="control-group">
                    <div class="control-label">Customer Name &nbsp;&nbsp; <span style="font-size:11px;">(Auto Complete)</span></div>
                    <div class="controls">
						<div class="control-group">
							<input type="text" name="customer_name" class="span12 customerSelection" placeholder='Type Customer Name' tabindex="3" required id="customer_name" >
							<input type="hidden" class="customer_hidden_value" name="customer_id" id="SchoolHiddenId"/>
						</div>
				    </div>
                </div>
            </div>
            <div class="span4">
				<div class="control-group">
					<label class="control-label" for="terms_and_condi">Terms and Conditions:</label>
					<div class="controls">
						<textarea class="input-description required" style="width:755px;height:165px;" tabindex="7"  rows="4" id="terms_and_condi" name="terms_and_condi" ></textarea>
					</div>
				</div>
            </div>
        </div>
		<div class="row-fluid">
			<table class="table table-condensed table-striped table-bordered">
				<thead>
					<tr>
						<th class="span4 text-right">Item Name&nbsp; <span style="font-size:11px;">(Auto Complete)</span></th>
						<th class="span3 text-right">Model No <span style="font-size:10px;">(Auto Show)</span> </th>
						<th class="span2 text-right">Rate <span style="font-size:10px;">(Auto Show)</span> </th>
						<th class="span2 text-right">Quantity</th>
						<th class="span1 text-right">Type  <span style="font-size:10px;">(Auto Show)</span> </th>
						<th class="span2 text-right">Total</th>
					</tr>
				</thead>
				<tbody id="addinvoiceItem">
					<tr>
						<td class="span3">
							<input type="text" name="product_name" onclick="invoice_productList(1);" class="span13 productSelection" placeholder='Type your Product Name' id="product_name" >
							<input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id[]" id="SchoolHiddenId"/>
							<input type="hidden" class="baseUrl" value="<?php echo base_url();?>" />
						</td>
						<td class="span2 text-right">
							<input type="text" name="model_no[]" id="model_no" class="model_no_1 span12" readonly="readonly"  />
						</td>
						<td class="span2">
							<input type="text" name="rate[]" id="product_rate_1" onkeyup="price_calculate(1);" class="required customer_rate_1 span12" />
						</td>
						<td class="span1 text-right">								
							<input type="text" name="quantity[]" onkeyup="price_calculate(1); stockLimit(1);" onchange="stockLimit(1)" id="product_quantity_1" class="required span12 product_quantity_1" />
						</td>
						<td class="span2 text-right">
							<span class="span9 qntt_type_1"></span>
						</td>
						<td class="span2 text-right">
							<input class="total_price span12 text-right" type="text" name="total_price[]" id="total_price_1" readonly="readonly" />
						</td>
						<td class='span1'>
							<span class="closeRow closeRow_1" onclick='close_table_row(1);' >&times;</span>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td>
							<input type="button" id="add-invoice-item" class="btn btn-info addItemButtonVisibility" name="add-invoice-item"  onClick="addInputField('addinvoiceItem');" value="Add new item" />
						</td>
						<td>
							&nbsp;<input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
						</td>
						<td style="text-align:right;" colspan="3"><b>Grand total:</b></td>
						<td class="text-right">
							<input type="text" id="total_amount" class="span12 text-right" name="total_amount" value="0.00" readonly="readonly" />
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="text-align:right;" colspan="5"><b>Discount (%):</b></td>
						<td class="text-right">
							<input type="text" id="discount" class="span12 text-right" tabindex="15" onkeyup='calculate_discount();' name="discount" value="0.00" />
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="text-align:right;" colspan="5"><b>Adjustment (minus):</b></td>
						<td class="text-right">
							<input type="text" id="adjustment" class="span12 text-right" tabindex="15" onkeyup='calculate_adjustment();' name="adjustment" value="0.00" />
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="text-align:right;" colspan="5"><b>Sub Total:</b></td>
						<td class="text-right">
							<input type="text" id="grandTotal" class="span12 text-right" name="grand_total_amount" tabindex="16" value="0.00" readonly="readonly" />
						</td>
						<td>&nbsp;</td>
					</tr>
				</tfoot>
			</table>
        </div>
        <div class="form-actions">
            <input type="submit" id="add-invoice" class="btn btn-primary btn-large saveItemButtonVisibility" name="add-invoice" value="Save" />
            <input type="submit" id="add-invoice2" class="btn btn-large" name="add-invoice-another" value="Save and add another one" />
			<a id="save-cancel" class="btn btn-danger btn-large" href="<?php echo base_url().'cinvoice'; ?>">Cancel</a>
        </div>
    </form>
</div>
