<script src="<?php echo base_url(); ?>my-assets/js/admin_js/all_form_validation.js" ></script>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/product_purchase.js.php" ></script>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/supplier.js.php" ></script>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/purchase.js" type="text/javascript"></script>
<div class="well">
	<div style="font-size:25px;font-weight:bold;">New Purchase</div>
</div>
<div class="form-container">
    <form class="form-vertical" action="<?=base_url()?>cpurchase/add_purchase" id="purchase" method="post"  name="purchase" enctype="multypart/formdata">
        <legend>Purchase detail</legend>
		<div class="row-fluid">
			<div class="span5">
				<div class="control-group">
					<label class="control-label">Supplier &nbsp; <span style="font-size:11px;">(Auto Complete)</span></label>
					<div class="controls">
					   <div class="input-append">
							 <input type="text" name="supplier_name" class="span12 supplierSelection required" placeholder='Type Supplier Name' tabindex="1" id="supplier_name" >
							 <input type="hidden" class="supplier_hidden_value" name="supplier_id" id="suppluerHiddenId"/>
							 <span class="btn"><a href="<?php echo base_url().'csupplier/add_supplier_form'; ?>">Add Supplier</a></span>
					   </div>
					</div>
				</div>
                <div class="control-group">
                    <label class="control-label" for="job_description">Job Descriptions:</label>
                    <div class="controls">
                        <textarea class="input-description required" required style="width:363px;height:97px;" rows="3" tabindex="4" id="job_description" name="job_description" ></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="ship_to">Ship To:tt</label>
                    <div class="controls">
                        <textarea class="input-description required" required style="width:363px;height:97px;" rows="6" tabindex="6" id="ship_to" name="ship_to" ></textarea>
                    </div>
                </div>
            </div>
            <div class="span4">
			<?php $date = date('Y-m-d'); ?>
            	<div class="control-group">
                    <label class="control-label">Date</label>
                    <div class="controls">
                        <input type="text" tabindex="2" class="span12 required" name="purchase_date" value="<?php echo date_numeric_format($date); ?>" required />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="created_by">Authorised By</label>
                    <div class="controls">
						<select name="authorised_by_id" class="span13" id="authorised_by_id">
							<option selected="selected" value="">..Select Authorised Person..</option> 
							{auth_person_list}
								<option value="{id}">{name}</option>  
							{/auth_person_list}
						</select>
					</div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="requested_by">Requested By</label>
                    <div class="controls">
						<select name="requested_by_id" class="span13" id="requested_by_id">
							<option selected="selected" value="">..Select Requested Person..</option> 
							{auth_person_list}
								<option value="{id}">{name}</option>  
							{/auth_person_list}
						</select>
					</div>
                </div>
				<div class="control-group">
					<label class="control-label" for="terms_and_condi">Terms and Conditions:</label>
					<div class="controls">
						<textarea class="input-description required" style="width:650px;height:97px;" tabindex="7"  rows="4" id="terms_and_condi" name="terms_and_condi" ></textarea>
					</div>
				</div>
            </div>
        </div>
		<div class="row-fluid">
			<table class="table table-condensed table-striped table-bordered">
				<thead>
					<tr>
						<th class="span4 text-right">Item Name &nbsp; <span style="font-size:11px;">(Auto Complete)</span></th>
						<th class="span2 text-right">Model <span style="font-size:10px;">(Auto Show)</span> </th>
						<th class="span2 text-right">Unit Price</th>
						<th class="span2 text-right">Quantity</th>
						<th class="span1 text-right">&nbsp;</th>
						<th class="span2 text-right">Total</th>
					</tr>
				</thead>
				<tbody id="addPurchaseItem">
					<tr>
						<td class="span4">
							<input type="text" name="product_name" onclick="purchase_productList(1);" required class="span12 productSelection" placeholder='Type your Product Name' id="product_name" >
							<input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id[]" id="SchoolHiddenId"/>
							<input type="hidden" class="baseUrl" value="<?php echo base_url();?>" />
						</td>
						<td class="span2 text-right">
							<span class="model_no_1" ></span>
						</td>
						<td class="span2 text-right">
							<input type="text" name="purchase_rate[]" id="purchase_rate_1" onkeyup="price_calculate(1);" class="span12 purchase_rate_1" placeholder='Purchase Rate' />
						</td>
						<td class="span2 text-right">
							<input type="text" name="product_quantity[]" onkeyup="price_calculate(1);" placeholder='Enter Quantity' tabindex="11" required  id="product_quantity_1" class="span12 required" />
						</td>
						<td class="span1 text-right"> <span class="qntt_type_1" ></span> </td>
						<td class="span2 text-right">
							<input class="total_price span12 text-right required" type="text" name="total_price[]" id="total_price_1" value="0.00" tabindex="13" readonly="readonly" />
						</td>
						<td class='span1'>
							<span class="closeRow closeRow_1" onclick='close_table_row(1);' >&times;</span>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td>
							<input type="button" id="add-invoice-item" class="btn btn-info" name="add-invoice-item"  onClick="addPurchaseInputField('addPurchaseItem');" value="Add new item" />
						</td>
						<td>
							&nbsp;<input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
						</td>
						<td style="text-align:right;" colspan="3"><b>Total:</b></td>
						<td class="text-right">
							<input type="text" id="total_amount" tabindex="14" class="span12 text-right" name="total_amount" value="0.00" readonly="readonly" />
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
			<input type="submit" id="add-purchase" class="btn btn-primary btn-large" name="add-purchase" value="Save" />
            <input type="submit" id="add-purchase2" class="btn btn-large" name="add-purchase-another" value="Save and add another one" />
			<a id="save-cancel" class="btn btn-danger btn-large" href="<?php echo base_url().'cpurchase'; ?>">Cancel</a>
        </div>
    </form>
</div>
<div class="test"></div>