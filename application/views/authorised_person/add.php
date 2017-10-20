<script src="<?php echo base_url(); ?>my-assets/js/admin_js/all_form_validation.js" ></script>
<h2>New Authorised Person</h2>
<div class="form-container">
    <form class="form-vertical" action="<?=base_url()?>cauthorised_person/add" id="auth_person" method="post"  name="auth_person" enctype="multypart/formdata">
        <legend>Authorised Person Details</legend>
		<div class="row-fluid">
            <div class="span5">
                <div class="control-group">
                    <label class="control-" for="name">Name:</label>
                    <div class="controls">
                        <input type="text" tabindex="1" class="span13" name="name" placeholder="Enter Name" />
                    </div>
                </div>
            </div>
            <div class="span5">
            	<div class="control-group">
                    <label class="control-label" for="designation">Designation:</label>
                    <div class="controls">
                        <input type="text" tabindex="2" class="span13" name="designation" placeholder="Enter Designation"/>
                    </div>
                </div>
            </div>
        </div>
		<div class="row-fluid">
            <div class="span5">
                <div class="control-group">
                    <label class="control-label" for="mobile_no">Mobile:</label>
                    <div class="controls">
                        <input type="text" tabindex="4" class="span13" name="mobile_no" placeholder="Enter Mobile Number"/>
                    </div>
                </div>
            </div>
            <div class="span5">
                <div class="control-group">
                    <label class="control-label" for="phone_no">Phone:</label>
                    <div class="controls">
                        <input type="text" tabindex="4" class="span13" name="phone_no" placeholder="Enter Phone Number"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <input type="submit" id="add-auth_person" class="btn btn-primary btn-large" tabindex="5" name="add-auth_person" value="Save" />
            <input type="submit" value="Save and add another one" name="add-auth_person-another" tabindex="6" class="btn btn-large" id="add-auth_person-another">
        </div>
    </form>
</div>
