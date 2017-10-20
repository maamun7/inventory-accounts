<script src="<?php echo base_url(); ?>my-assets/js/admin_js/users.js" type="text/javascript"></script>
<div class="page-header"><h1>Add new user</h1></div>
<div class="row span6 well">
    <form class="form-horizontal" action="<?=base_url()?>cuser/insert_user" id="user" method="post"  name="user" enctype="multypart/formdata">
         <fieldset>
            <legend>Basic info</legend>
            <div class="control-group">
                <label class="control-label" for="first_name">First name</label>
                <div class="controls">
                    <input type="text" placeholder="First name" class="required" id="first_name" name="first_name" value="" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="last_name">Last name</label>
                <div class="controls">
                    <input type="text" placeholder="Last name" class="" id="last_name" name="last_name" value="" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="designation">Designation</label>
                <div class="controls">
                    <input type="text" placeholder="Designation" class="" id="designation" name="designation" value="" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="address">Address</label>
                <div class="controls">
                    <textarea id="address" name="address" placeholder="Address"></textarea>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Login info</legend>
            <div class="control-group">
                <label class="control-label" for="email">Email</label>
                <div class="controls">
                    <input type="text" placeholder="User's email address" class="" id="email" name="email" value="" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="password">Password</label>
                <div class="controls">
                    <input type="password" placeholder="Password" class="" id="password" name="password" value="" />
                </div>
            </div>
        </fieldset>
         <fieldset>
            <legend>System info</legend>
            <div class="control-group">
                <label class="control-label" for="">Can login</label>
                <div class="controls">
                    <input type="radio" class="" name="can_login" value="1" checked="checked">&nbsp; Yes.
                    <input type="radio" class="" name="can_login" value="0">&nbsp; No.
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="is_active">Active status</label>
                <div class="controls">
                    <select id="is_active" name="is_active" class="">
                        <option value="1">Active</option>
                        <option value="0">Deactive</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="role_id">Set role</label>
                <div class="controls">
                    <select id="role_id" name="role_id" class="">
                        {roles}
                        <option value="{role_id}">{role}</option>
                        {/roles}
                    </select>
                </div>
            </div>
        </fieldset>
        <div class="form-actions">
        	<input type="submit" id="add-new-user" class="btn btn-primary" name="add-new-user" value="Add user" />
        </div>
    </form>
</div>