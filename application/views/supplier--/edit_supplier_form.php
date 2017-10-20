<h2>Edit Supplier</h2>
<div class="form-container">
    <form class="form-vertical" action="<?=base_url()?>csupplier/supplier_update" id="insert_supplier" method="post"  name="insert_product" enctype="multypart/formdata">
        <legend>Supplier detail</legend>
        <div class="row-fluid">
			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th class="span5 text-right">Supplier Name</th>
						<th class="span5 text-right">Supplier Mobile</th>
						<th class="span3">&nbsp;</th>
						<th class="span3">&nbsp;</th>
						<th class="span3">&nbsp;</th>
						<th class="span3">&nbsp;</th>
					</tr>
				</thead>
				<tbody id="form-actions">
					<tr class="">
						<td class="span5">
							<input type="number" tabindex="1" class="span13" name="supplier_name" name="supplier_id" value="{supplier_name}"  placeholder="Supplier Name" required />
						</td>
						<td class="span5">
							<input type="number" tabindex="2" class="span13" name="mobile" name="supplier_id" value="{mobile}"  placeholder="Supplier Mobile" required />
						</td>
						<td class="span1 text-right">
						</td>
						<td class="span1 text-right">
						</td>
						<td class="span1 text-right">
						</td>
						<td class="span1 text-right">
							<input type="hidden" name="supplier_id" value="{supplier_id}" />
						</td>
					</tr>
				</tbody>
			</table>
        </div>
		<div class="row-fluid">
            <div class="span3">
                <div class="control-group">
                    <label class="control-" for="invoice_date">Supplier Adress:</label>
                    <div class="controls">
                        <textarea class="span12 input-description" tabindex="3" id="adress" name="address" placeholder=" Supplier Adress" required>{address}</textarea>
                    </div>
                </div>
            </div>
            <div class="span3">
            	<div class="control-group">
                    <label class="control-label">Supplier Details:</label>
                    <div class="controls">
                        <textarea class="span12 input-description" tabindex="4" id="details" name="details" placeholder=" Supplier Details" required>{details}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <input type="submit" id="add-supplier" class="btn btn-primary btn-large" tabindex="5" name="add-supplier" value="Save Changes" />
        </div>
    </form>
</div>
