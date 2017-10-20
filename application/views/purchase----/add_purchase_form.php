<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/product_purchase.js.php" ></script>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/supplier.js.php" ></script>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/purchase.js" type="text/javascript"></script>
<div class="well">
	<div style="font-size:25px;font-weight:bold;">New Purchase</div>
</div>
<div class="form-container">
    <form class="form-vertical" action="<?=base_url()?>cpurchase/insert_purchase" id="insert_purchase" method="post"  name="insert_purchase" enctype="multypart/formdata">
        <legend>Purchase detail</legend>
		<div class="row-fluid">
			<div class="span3">
				<?php $date = date('Y-m-d'); ?>
            	<div class="control-group">
                    <label class="control-label">Date</label>
                    <div class="controls">
                        <input type="text" tabindex="3" class="span13" name="purchase_date" value="<?php echo $date; ?>" required />
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Chalan No</label>
                    <div class="controls">
                        <input type="text" tabindex="3" readonly="readonly" class="span13" name="chalan_no" value="{chalan_number}" readonly="readonly" required />
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Supplier</label>
                    <div class="controls">
						<div class="input-append">
							<input type="text" name="supplier_name" class="span10 supplierSelection" placeholder='Type Supplier Name' id="supplier_name" >
							<input type="hidden" class="supplier_hidden_value" name="supplier_id" id="suppluerHiddenId"/>
							<span class="btn"><a href="<?php echo base_url().'csupplier/add_supplier_form'; ?>">Add Supplier</a></span>
						</div>
					</div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-" for="invoice_date">Details:</label>
                    <div class="controls">
                        <textarea class="span12 input-description" tabindex="1" id="adress" name="purchase_details" placeholder=" Details" required></textarea>
                    </div>
                </div>
            </div>
        </div>
		<div class="row-fluid">
			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th class="span3 text-right">Item Information</th>
						<th class="span1 text-right">Model No (Auto Show)</th>
						<th class="span1 text-right">Quantity</th>
						<th class="span1 text-right">&nbsp;</th>
						<th class="span2 text-right">Rate</th>
						<th class="span2 text-right">Total</th>
					</tr>
				</thead>
				<tbody id="addPurchaseItem">
					<tr>
						<td class="span3">
							<input type="text" name="product_name" onclick="purchase_productList(1);" required class="span10 productSelection" placeholder='Type your Product Name' id="product_name" >
							<input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id[]" id="SchoolHiddenId"/>
							<input type="hidden" class="baseUrl" value="<?php echo base_url();?>" />
						</td>
						<td class="span1 text-right">
							<span class="model_no_1" ></span>
						</td>
						<td class="span1 text-right">
							<input type="text" name="product_quantity[]" onkeyup="price_calculate(1);" required  id="product_quantity_1" class="span12" />
						</td>
						<td class="span1 text-right">	
							<span class="qntt_type_1" ></span>
						</td>
						<td class="span1 text-right">
							<input type="text" name="purchase_rate[]" id="purchase_rate_1" onkeyup="price_calculate(1);" class="purchase_rate_1" />
						</td>
						<td class="span2 text-right">
							<input class="total_price span8 text-right" type="text" name="total_price[]" id="total_price_1" value="0.00" tabindex="-1" readonly="readonly" />
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
						<td style="text-align:right;" colspan="3"><b>Grand total:</b></td>
						<td class="text-right">
							<input type="text" id="grandTotal" tabindex="-1" class="span8 text-right" name="grand_total_price" tabindex="-1" value="0.00" readonly="readonly" />
						</td>
						<td>&nbsp;</td>
					</tr>
				</tfoot>
			</table>
        </div>
        <div class="form-actions">
            <input type="submit" id="add-purchase" class="btn btn-primary btn-large" name="add-purchase" value="Submit" />
            <input type="submit" value="Submit and add another one" name="add-purchase-another" class="btn btn-large" id="add-purchase-another">
        </div>
    </form>
</div>
<div class="test"></div>