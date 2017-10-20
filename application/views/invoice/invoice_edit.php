<h2>Edit Invoice</h2>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/all_form_validation.js" ></script>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/product_invoice.js.php" ></script>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/customer.js.php" ></script>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/invoice.js" type="text/javascript"></script>
<div class="form-container">
    <form class="form-vertical" action="<?=base_url()?>cinvoice/edit_invoice" id="invoice" method="post"  name="insert_invoice" enctype="multypart/formdata">
        <legend>invoice detail</legend>
		<div class="row-fluid">
			<div class="span4">
				<?php $date = date('Y-m-d'); ?>
            	<div class="control-group">
                    <label class="control-label">Date</label>
                    <div class="controls">
                        <input type="text" tabindex="1" class="span12" name="created_on" required value="{final_date}" required />
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label" for="created_by">Authorised By</label>
                    <div class="controls">
						<select name="authorised_by_id" class="span12" id="authorised_by_id" tabindex="2" >
							<option selected="selected" value="">..Select Authorised Person..</option> 
							{auth_person_list}
								<option value="{id}" {selected}>{name}</option>  
							{/auth_person_list}
						</select>
					</div>
                </div>
				<div class="control-group">
                    <div class="control-label">Customer Name &nbsp;&nbsp; <span style="font-size:11px;">(Auto Complete)</span></div>
                    <div class="controls">
						<div class="control-group">
							<input type="text" name="customer_name" class="span12 customerSelection" placeholder='Type Customer Name' tabindex="3" value="{customer_name}" id="customer_name" >
							<input type="hidden" class="customer_hidden_value" name="customer_id" value="{customer_id}"  id="SchoolHiddenId"/>
						</div>
				    </div>
                </div>
            </div>
            <div class="span4">
				<div class="control-group">
					<label class="control-label" for="terms_and_condi">Terms and Conditions:</label>
					<div class="controls">
						<textarea class="input-description required" style="width:755px;height:165px;" tabindex="7"  rows="4" id="terms_and_condi" name="terms_and_condi" >{terms_and_condi}</textarea>
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
				<tbody id="editinvoiceItem">
					{invoice_all_data}
					<tr>
						<td class="span3">
							<input type="text" name="product_name" onclick="invoice_productList({sl});" value="{product_name}" required class="span12 productSelection" placeholder='Type your Product Name' id="product_name" >
							<input type="hidden" class="autocomplete_hidden_value product_id_{sl}" name="product_id[]" value="{product_id}" id="SchoolHiddenId"/>
							<input type="hidden" class="baseUrl" value="<?php echo base_url();?>" />
						</td>
						<td class="span2 text-right">
							<input type="text" name="model_no[]" id="model_no" value="{product_model}" class="model_no_{sl} span12" readonly="readonly"  />
						</td>
						<td class="span2">
							<input type="text" name="rate[]" value="{rate}" id="product_rate_{sl}" onkeyup="price_calculate({sl});" class="customer_rate_{sl} span12" />
						</td>
						<td class="span1 text-right">								
							<input type="text" name="quantity[]" value="{quantity}" onkeyup="price_calculate({sl}); stockLimitForInvoiceEdit({sl})" id="product_quantity_{sl}" class="span12 product_quantity_{sl}" />
							<input type="hidden" id="existing_quantity_{sl}" value="{quantity}" />
						</td>
						<td class="span2 text-right">
							<span class="span9 qntt_type_{sl}">{quantity_type}</span>
						</td>
						<td class="span2 text-right">
							<input class="total_price span12 text-right" type="text" name="total_price[]" id="total_price_{sl}" value="{total_price}" readonly="readonly" />
							<input type="hidden" name="invoice_details_id[]" id="invoice_details_id" value="{invoice_details_id}"/>
						</td>
						<td class='span1'>
							<span class="closeRow closeRow_1" onclick='delete_invoice_single_row({invoice_details_id});' >&times;</span>
						</td>
					</tr>
					{/invoice_all_data}
				</tbody>
				<tfoot>
					<tr>
						<td>
							<input type="button" id="edit-invoice-item" class="btn btn-info addItemButtonVisibility" name="edit-invoice-item"  onClick="editPurchaseInputField('editinvoiceItem');" value="Add new item" />
						</td>
						<td>
							&nbsp;<input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
							&nbsp;<input type="hidden" name="invoice_id" id="invoice_id" value="{invoice_id}"/>
						</td>
						<td style="text-align:right;" colspan="3"><b>Grand total:</b></td>
						<td class="text-right">
							<input type="text" id="total_amount" class="span12 text-right" name="total_amount" value="{price_total}" readonly="readonly" />
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="text-align:right;" colspan="5"><b>Discount (%):</b></td>
						<td class="text-right">
							<input type="text" id="discount" class="span12 text-right" tabindex="15" onkeyup='calculate_discount();' name="discount" value="{discount}" />
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="text-align:right;" colspan="5"><b>Adjustment (minus):</b></td>
						<td class="text-right">
							<input type="text" id="adjustment" class="span12 text-right" tabindex="15" onkeyup='calculate_adjustment();' name="adjustment" value="{adjustment}" />
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="text-align:right;" colspan="5"><b>Sub Total:</b></td>
						<td class="text-right">
							<input type="text" id="grandTotal" class="span12 text-right" name="grand_total_amount" tabindex="16" value="{grand_total}" readonly="readonly" />
						</td>
						<td>&nbsp;</td>
					</tr>
				</tfoot>
			</table>
        </div>
		<div class="form-actions">
            <input type="submit" id="add-invoice" class="btn btn-primary btn-large saveItemButtonVisibility" name="add-invoice" value="Save Changes" />
			<a id="save-cancel" class="btn btn-danger btn-large" href="<?php echo base_url().'cinvoice'; ?>">Cancel</a>
        </div>
    </form>
</div>