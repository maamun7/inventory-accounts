<script src="<?php echo base_url(); ?>my-assets/js/admin_js/all_form_validation.js" ></script>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/product_purchase.js.php" ></script>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/supplier.js.php" ></script>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/purchase.js" type="text/javascript"></script>
<div class="well">
	<div style="font-size:25px;font-weight:bold;">Edit Purchase</div>
</div>
<div class="form-container">
    <form class="form-vertical" action="<?=base_url()?>cpurchase/edit_purchase" id="purchase" method="post"  name="purchase" enctype="multypart/formdata">
        <legend>Purchase detail</legend>
		<div class="row-fluid">
			<div class="span5">
				<div class="control-group">
					<label class="control-label">Supplier</label>
					<div class="controls">
						<div class="controls">
							<input type="text" name="supplier_name" value="{supplier_name}" class="span10 supplierSelection" placeholder='Type your Supplier Name' tabindex="1" id="supplier_name" >
							<input type="hidden" class="supplier_hidden_value" name="supplier_id" value="{supplier_id}" id="suppluerHiddenId"/>
						</div>
					</div>
			    </div>
				 <div class="control-group">
                    <label class="control-label" for="job_description">Job Descriptions:</label>
                    <div class="controls">
                        <textarea class="input-description" style="width:375px;height:97px;" rows="3" tabindex="4" id="job_description" name="job_description" >{job_description}</textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="ship_to">Ship To:</label>
                    <div class="controls">
                        <textarea class="input-description" style="width:375px;height:97px;" rows="6" tabindex="6" id="ship_to" name="ship_to" >{ship_to}</textarea>
                    </div>
                </div>
            </div>
            <div class="span4">
				<?php $date = date('Y-m-d'); ?>
            	<div class="control-group">
                    <label class="control-label">Date</label>
                    <div class="controls">
                        <input type="text" tabindex="2" class="span12" name="purchase_date" value="<?php echo date_numeric_format($purchase_date); ?>" required />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="created_by">Authorised By</label>
                    <div class="controls">
						<select name="authorised_by_id" class="span13" id="authorised_by_id">
							<option value="">..Select Authorised Person..</option> 
							{auth_person_list}
								<option value="{id}" {selected}>{name}</option>  
							{/auth_person_list}
						</select>
					</div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="requested_by">Requested By</label>
                    <div class="controls">
						<select name="requested_by_id" class="span13" id="requested_by_id">
							<option value="">..Select Requested Person..</option> 
							{req_person_list}
								<option value="{id}"{selected}>{name}</option>  
							{/req_person_list}
						</select>
					</div>
                </div>
				<div class="control-group">
					<label class="control-label" for="terms_and_condi">Terms and Conditions:</label>
					<div class="controls">
						<textarea class="input-description" style="width:650px;height:97px;" tabindex="7"  rows="4" id="terms_and_condi" name="terms_and_condi" >{terms_and_condi}</textarea>
					</div>
				</div>
            </div>
        </div>
		<div class="row-fluid">
			<table class="table table-condensed table-striped table-bordered">
				<thead>
					<tr>
						<th class="span4 text-right">Item Name</th>
						<th class="span2 text-right">Model No</th>
						<th class="span2 text-right">Unit Price</th>
						<th class="span2 text-right">Quantity</th>
						<th class="span1 text-right">&nbsp;</th>
						<th class="span2 text-right">Total</th>
					</tr>
				</thead>
				<tbody id="addPurchaseItem">
				{purchase_info}
					<tr>
						<td class="span4">
							<input type="text" name="product_name" onclick="purchase_productList({sl});" value="{product_name}" required class="span12 productSelection" placeholder='Type your Product Name' id="product_name" >
							<input type="hidden" class="autocomplete_hidden_value product_id_{sl}" name="product_id[]" value="{product_id}" id="SchoolHiddenId"/>
						</td>
						<td class="span2 text-right">
							<span class="model_no_1" >{product_model}</span>
						</td>
						<td class="span2 text-right">
							<input type="text" name="purchase_rate[]" id="purchase_rate_{sl}" onkeyup="price_calculate({sl});" value="{rate}" placeholder='Purchase Rate' class="span12 purchase_rate_{sl}" />
						</td>
						<td class="span2 text-right">
							<input type="text" name="product_quantity[]" onkeyup="price_calculate({sl});" placeholder='Enter Quantity' value="{quantity}" required  id="product_quantity_{sl}" class="span12" />
						</td>
						<td class="span1 text-right">	
							<span class="qntt_type_{sl}" >{quantity_type}</span>
						</td>
						<td class="span2 text-right">
							<input class="total_price span12 text-right" type="text" name="total_price[]" id="total_price_{sl}" value="{total_amount}" readonly="readonly" />
							<input type="hidden" name="purchase_detail_id[]" value="{purchase_detail_id}"/>
						</td>
                        <td class='span1'>
							<span class="closeRow closeRow_{sl}" onclick='close_table_row({sl});delete_single_row({purchase_detail_id})' >&times;</span>
						</td>
					</tr>
				{/purchase_info}
				</tbody>
				<tfoot>
					<tr>
						<td>
							<input type="button" id="add-invoice-item" class="btn btn-info" name="add-invoice-item"  onClick="editPurchaseInputField('addPurchaseItem');" value="Add new item" />
						</td>
						<td>
							&nbsp;<input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
							&nbsp;<input type="hidden" name="purchase_id" class="purchase_id" value="{purchase_id}"/>							
						</td>
						<td style="text-align:right;" colspan="3"><b>Grand total:</b></td>
						<td class="text-right">
							<input type="text" id="total_amount" value="{total_price}" class="span12 text-right" name="total_amount" readonly="readonly" />
						</td>
                        <td class='span1'>
							<span class="closeRow"></span>
						</td>
					</tr>
					<tr>
						<td style="text-align:right;" colspan="5"><b>Discount (%):</b></td>
						<td class="text-right">
							<input type="text" id="discount" class="span12 text-right" onkeyup='calculate_discount();' name="discount" value="{discount}"  />
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="text-align:right;" colspan="5"><b>Adjustment (minus):</b></td>
						<td class="text-right">
							<input type="text" id="adjustment" class="span12 text-right" tabindex="11" onkeyup='calculate_adjustment();' name="adjustment" value="{adjustment}" />
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td style="text-align:right;" colspan="5"><b>Sub Total:</b></td>
						<td class="text-right">
							<input type="text" id="grandTotal" class="span12 text-right" name="grand_total_amount"  value="{grand_total}"  readonly="readonly" />
						</td>
						<td>&nbsp;</td>
					</tr>
				</tfoot>
			</table>
        </div>
        <div class="form-actions">
            <input type="submit" id="save-purchase" class="btn btn-primary btn-large" name="save-purchase" value="Save Changes" />
            <a id="save-cancel" class="btn btn-danger btn-large" href="<?php echo base_url().'cpurchase'; ?>">Cancel</a>
        </div>
    </form>
</div>