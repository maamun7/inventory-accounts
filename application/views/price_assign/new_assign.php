<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/customer.js.php" ></script>
<script src="<?php echo base_url(); ?>my-assets/js/admin_js/price_assign.js.php" ></script>
<h2>Assign Price for Specific Customer</h2>
<div class="form-container">
    <form class="form-vertical" action="<?=base_url()?>cprice_assign/insert_assign_price" id="assign_price" method="post"  name="insert_product" enctype="multypart/formdata">
        <div class="row-fluid">
			<table class="table table-condensed table-striped table-bordered">
				<thead>
					<tr>
						<th class="span5 text-right">Customer Name</th>
						<th class="span5 text-right">Product Name</th>
						<th class="span3">Model No:</th>
						<th class="span3">Purchase Price</th>
					</tr>
				</thead>
				<tbody id="form-actions">
					<tr class="">
						<td class="span5">
							<input type="text" tabindex="1" class="span13 customerSelection" name="customer_name" placeholder="Type Customer Name" required />
							<input type="hidden" class="customer_hidden_value" name="customer_id" id="SchoolHiddenId"/>
						</td>
						<td class="span5">
							<input type="text" name="product_name" onclick="price_assign_productList();" required class="span12 productSelection" placeholder='Type your Product Name' id="product_name" >
							<input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id" id="SchoolHiddenId"/>
						</td>
						<td class="span1 text-right">
							<input type="text" name="model_no" required class="span12 model_no" placeholder='Model No' id="model_no" readonly="readonly" >
						</td>
						<td class="span1 text-right">
							<input type="text" name="purchase_price" required class="span12 purchase_price" placeholder='Purchase Price' id="purchase_price" readonly="readonly" >							
							<input type="hidden" name="baseUrl" class="baseUrl" value="<?php echo base_url();?>"/>
						</td>
					</tr>
				</tbody>
			</table>
        </div>
		<div class="row-fluid">
            <div class="span3">
            	<div class="control-group">
                    <label class="control-label">Price For This Customer</label>
                    <div class="controls">
                        <input type="number" tabindex="3" class="span13 price numericField" name="price" placeholder="Price For This Customer" required />
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <input type="submit" id="add-customer" class="btn btn-primary btn-large" name="add-customer" value="Save" />
            <input type="submit" value="Save and Assign another One" name="add-customer-another" class="btn btn-large" id="add-customer-another">
        </div>
    </form>
</div>
<div class="test"></div>
