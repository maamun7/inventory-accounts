<h2>Edit Product</h2>
<div class="form-container">
    <form class="form-vertical" action="<?=base_url()?>cproduct/product_update" id="insert_product" method="post"  name="insert_product" enctype="multypart/formdata">
        <legend>Product detail</legend>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="invoice_date">Product Name:</label>
                    <div class="controls">
                        <input type="text" class="span10" tabindex="1" id="product_name" name="product_name" value="{product_name}" placeholder="Product Name" required />
                    </div>
                </div>
            </div>
            <div class="span8">
            	<div class="control-group">
                    <label class="control-label">Description:</label>
                    <div class="controls">
                        <textarea class="span6 input-description" tabindex="2" id="description" name="description" placeholder="Optional detail about this purchase" required>{product_details}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th class="span2 text-right">Cartoon Quantity</th>
						<th class="span2 text-right">Price</th>
						<th class="span2 text-right">Model</th>
						<th class="span3">&nbsp;</th>
						<th class="span3">&nbsp;</th>
						<th class="span3">&nbsp;</th>
					</tr>
				</thead>
				<tbody id="form-actions">
					<tr class="">
						<td class="span2">
							<select name="quantity_type" id="quantity_type" class="span12" tabindex="3" style="text-align:center;" required>
								<option value="">...Select Type...</option>  
								<option value="Pieces" <?php if($quantity_type == "Pieces"){echo "selected='selected'";}?>>Pieces</option>  
								<option value="Dozen" <?php if($quantity_type == "Dozen"){echo "selected='selected'";}?>>Dozen</option>  
								<option value="Kg" <?php if($quantity_type == "Kg"){echo "selected='selected'";}?>>Kg</option>  
								<option value="GM" <?php if($quantity_type == "GM"){echo "selected='selected'";}?>>GM</option>  
								<option value="Rim" <?php if($quantity_type == "Rim"){echo "selected='selected'";}?>>Rim</option>  
								<option value="Jar" <?php if($quantity_type == "Jar"){echo "selected='selected'";}?>>Jar</option>  
								<option value="Box" <?php if($quantity_type == "Box"){echo "selected='selected'";}?>>Box</option>  
								<option value="Pack" <?php if($quantity_type == "Pack"){echo "selected='selected'";}?>>Pack</option>  
								<option value="Set" <?php if($quantity_type == "Set"){echo "selected='selected'";}?>>Set</option>  
								<option value="Pot" <?php if($quantity_type == "Pot"){echo "selected='selected'";}?>>Pot</option>  
								<option value="Packet" <?php if($quantity_type == "Packet"){echo "selected='selected'";}?>>Packet</option> 
							</select>
						</td>
						<td class="span2">
							<input type="text" tabindex="4" class="span12 text-right numericField" name="purchase_price" value="{purchase_price}" placeholder="Purchase Price"  required />
						</td>
						<td class="span2 text-right">
							<input type="text" tabindex="5" class="span12 text-right" name="model" value="{product_model}" placeholder="Model"  required />
						</td>
						<td class="span1 text-right">
							<input type="hidden" name="product_id" value="{product_id}" />
						</td>
						<td class="span1 text-right">
						</td>
						<td class="span1 text-right">
						</td>
					</tr>
				</tbody>
			</table>
        </div>
        <div class="form-actions">
            <input type="submit" id="add-product" tabindex="6" class="btn btn-primary btn-large" name="add-product" value="Save Changes" />
        </div>
    </form>
</div>
