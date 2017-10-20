<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/product_purchase.js.php" ></script>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/supplier.js.php" ></script>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/purchase.js" type="text/javascript"></script>
<div class="well">
	<div style="font-size:25px;font-weight:bold;">Edit Purchase</div>
</div>
<div class="form-container">
    <form class="form-vertical" action="<?=base_url()?>cpurchase/purchase_update" id="purchase_update" method="post"  name="purchase_update" enctype="multypart/formdata">
        <legend>Purchase detail</legend>
		<div class="row-fluid">
			<div class="span3">
            	<div class="control-group">
                    <label class="control-label">Date</label>
                    <div class="controls">
                        <input type="text" tabindex="3" class="span13" name="purchase_date" value="{purchase_date}" required />
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Chalan No</label>
                    <div class="controls">
                        <input type="text" tabindex="3" readonly="readonly"  class="span13" name="chalan_no" value="{chalan_no}" placeholder="Chalan No" required />
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">Supplier</label>
                    <div class="controls">
                        <input type="text" name="supplier_name" value="{supplier_name}" class="span13 supplierSelection" placeholder='Type your Supplier Name' id="supplier_name" >
						<input type="hidden" class="supplier_hidden_value" name="supplier_id" value="{supplier_id}" id="suppluerHiddenId"/>
					</div>
                </div>
            </div>
            <div class="span3">
                <div class="control-group">
                    <label class="control-" for="invoice_date">Details:</label>
                    <div class="controls">
                        <textarea class="span12 input-description" tabindex="1" id="adress" name="purchase_details" placeholder=" Details" required>{purchase_details}</textarea>
                    </div>
                </div>
            </div>
        </div>
		<div class="row-fluid">
			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th class="span3 text-right">Item Information</th>
						<th class="span1 text-right">Model No</th>
						<th class="span1 text-right">Quantity</th>
						<th class="span1 text-right">&nbsp;</th>
						<th class="span2 text-right">Rate</th>
						<th class="span2 text-right">Total</th>
					</tr>
				</thead>
				<tbody id="addPurchaseItem">
				{purchase_info}
					<tr>
						<td class="span3">
							<input type="text" name="product_name" onclick="purchase_productList({sl});" value="{product_name}" required class="span11 productSelection" placeholder='Type your Product Name' id="product_name" >
							<input type="hidden" class="autocomplete_hidden_value product_id_{sl}" name="product_id[]" value="{product_id}" id="SchoolHiddenId"/>
						</td>
						<td class="span1 text-right">
							<span class="model_no_{sl}" >{product_model}</span>
						</td>
						<td class="span1 text-right">
							<input type="text" name="product_quantity[]" onkeyup="price_calculate({sl});" value="{quantity}" required  id="product_quantity_{sl}" class="span12" />
						</td>
						<td class="span1 text-right">	
							<span class="qntt_type_{sl}" >{quantity_type}</span>
						</td>
						<td class="span1 text-right">
							<input type="text" name="purchase_rate[]" value="{rate}" id="purchase_rate_{sl}" onkeyup="price_calculate({sl});" class="purchase_rate_{sl}" />
						</td>
						<td class="span2 text-right">
							<input class="total_price span8 text-right" type="text" name="total_price[]" id="total_price_{sl}" value="{total_amount}" tabindex="-1" readonly="readonly" />
							<input type="hidden" name="purchase_detail_id[]" value="{purchase_detail_id}"/>
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
							<input type="text" id="grandTotal" value="{grand_total}" class="span8 text-right" name="grand_total_price" readonly="readonly" />
						</td>
					</tr>
				</tfoot>
			</table>
        </div>
        <div class="form-actions">
            <input type="submit" id="add-purchase" class="btn btn-primary btn-large" name="add-purchase" value="Save Changes" />
        </div>
    </form>
</div>