<h2>Edit Customer</h2>
<div class="form-container">
    <form class="form-vertical" action="<?=base_url()?>ccustomer/customer_update" id="insert_customer" method="post"  name="insert_product" enctype="multypart/formdata">
        <legend>Customer detail</legend>
        <div class="row-fluid">
			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th class="span5 text-right">Customer Name</th>
						<th class="span5 text-right">Customer Mobile</th>
						<th class="span3">&nbsp;</th>
						<th class="span3">&nbsp;</th>
						<th class="span3">&nbsp;</th>
						<th class="span3">&nbsp;</th>
					</tr>
				</thead>
				<tbody id="form-actions">
					<tr class="">
						<td class="span5">
							<input type="text" tabindex="1" class="span13" name="customer_name" name="customer_id" value="{customer_name}"  placeholder="Customer Name" required />
						</td>
						<td class="span5">
							<input type="text" tabindex="2" class="span13" name="mobile" name="mobile" value="{customer_mobile}"  placeholder="Customer Mobile" required />
						</td>
						<td class="span1 text-right">
						</td>
						<td class="span1 text-right">
						</td>
						<td class="span1 text-right">
						</td>
						<td class="span1 text-right">
							<input type="hidden" name="customer_id" value="{customer_id}" />
						</td>
					</tr>
				</tbody>
			</table>
        </div>
		<div class="row-fluid">
            <div class="span3">
                <div class="control-group">
                    <label class="control-" for="invoice_date">Customer Adress:</label>
                    <div class="controls">
                        <textarea class="span12 input-description" tabindex="3" id="adress" name="address" placeholder=" Customer Adress" required>{customer_address}</textarea>
                    </div>
                </div>
            </div>
            <div class="span3">
            	<div class="control-group">
                    <label class="control-label">Customer Email:</label>
                    <div class="controls">
                        <input type="text" tabindex="4" class="span13" value="{customer_email}" name="email" placeholder="Customer Email" required />
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <input type="submit" id="add-Customer" class="btn btn-primary btn-large" tabindex="6" name="add-Customer" value="Save Changes" />
        </div>
    </form>
</div>
