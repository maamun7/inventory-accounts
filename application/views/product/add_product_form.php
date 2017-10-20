<h2>New Product</h2>
<div class="form-container">
    <form class="form-vertical" action="<?=base_url()?>cproduct/insert_product" id="insert_product" method="post"  name="insert_product" enctype="multypart/formdata">
        <legend>Product detail</legend>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <label class="control-label" for="invoice_date">Product Name:</label>
                    <div class="controls">
                        <input type="text" class="span10" tabindex="1" id="product_name" name="product_name" placeholder="Product Name" required />
                    </div>
                </div>
            </div>
            <div class="span8">
            	<div class="control-group">
                    <label class="control-label">Description:</label>
                    <div class="controls">
                        <textarea class="span6 input-description" tabindex="2" id="description" name="description" placeholder="Optional detail about this purchase" required></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th class="span2 text-right">Type Quantity</th>
						<th class="span2 text-right">Purchase Price</th>
						<th class="span2 text-right">Model</th>
						<th class="span3">&nbsp;</th>
						<th class="span3">&nbsp;</th>
						<th class="span3">&nbsp;</th>
					</tr>
				</thead>
				<tbody id="form-actions">
					<tr class="">
						<td class="span2">
							<select name="quantity_type" id="quantity_type" class="span12" style="text-align:center;" tabindex="3" required>
								<option value="">...Select Type...</option>  
								<option value="Pieces">Pieces</option>  
								<option value="Dozen">Dozen</option>  
								<option value="Kg">Kg</option>  
								<option value="GM">GM</option>  
								<option value="Rim">Rim</option>  
								<option value="jar">Jar</option>  
								<option value="Box">Box</option>  
								<option value="Pack">Pack</option>  
								<option value="Set">Set</option>  
								<option value="Pot">Pot</option>  
								<option value="Packet">Packet</option>  
							</select>
						</td>
						<td class="span2">
							<input type="text" tabindex="4" class="span12 text-right numericField" name="price" placeholder="Purchase Price"  required />
						</td>
						<td class="span2 text-right">
							<input type="text" tabindex="5" class="span12 text-right" name="model" placeholder="Model" />
						</td>
						<td class="span1 text-right">
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
            <input type="submit" id="add-product" class="btn btn-primary btn-large" tabindex="6" name="add-product" value="Save" />
            <input type="submit" value="Save and add another one" name="add-product-another" tabindex="7" class="btn btn-large" id="add-product-another">
        </div>
    </form>
</div>
