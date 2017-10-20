<script src="<?php echo base_url(); ?>my-assets/js/admin_js/users.js" type="text/javascript"></script>
<div class="page-header"><h1>Edit User</h1></div>
<div class="row span6 well">
    <form class="form-horizontal" action="<?=base_url()?>cuser/user_update" id="user" method="post"  name="user" enctype="multypart/formdata">
         <fieldset>
            <legend>Basic info</legend>
            <div class="control-group">
                <label class="control-label" for="first_name">First name</label>
                <div class="controls">
                    <input type="text" placeholder="First name" class="required" id="first_name" name="first_name" value="{first_name}" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="last_name">Last name</label>
                <div class="controls">
                    <input type="text" placeholder="Last name" class="" id="last_name" name="last_name" value="{last_name}" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="designation">Designation</label>
                <div class="controls">
                    <input type="text" placeholder="Designation" class="" id="designation" name="designation" value="{designition}" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="address">Address</label>
                <div class="controls">
                    <textarea id="address" name="address" placeholder="Address">{address}</textarea>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Login info</legend>
            <div class="control-group">
                <label class="control-label" for="email">Email</label>
                <div class="controls">
                    <input type="text" placeholder="User's email address" class="" id="email" name="email" value="{email}" />
                </div>
            </div>
        </fieldset>
         <fieldset>
            <legend>System info</legend>
            <div class="control-group">
                <label class="control-label" for="">Can login</label>
                <div class="controls">
                    <input type="radio" <?php if(isset($can_login) && $can_login ==1){echo 'checked="checked"';} ?> name="can_login" value="1" checked="checked">&nbsp; Yes.
                    <input type="radio" <?php if(isset($can_login) && $can_login ==0){echo 'checked="checked"';} ?> name="can_login" value="0">&nbsp; No.
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="is_active">Active status</label>
                <div class="controls">
                    <select id="is_active" name="is_active" class="">
                        <option value="1" <?php if(isset($is_active) && $is_active ==1){echo "selected='selected'";} ?> >Active</option>
                        <option value="0" <?php if(isset($is_active) && $is_active ==0){echo "selected='selected'";} ?> >Deactive</option>
                    </select>
                </div>
            </div>
			<?php if(isset($user_type) && $user_type ==1){ ?>
            <div class="control-group">
                <label class="control-label" for="role_id">Set role</label>
                <div class="controls">
                    <select id="role_id" name="role_id" class="">
                        <option value="0" {selected} >Register User</option>
                    </select>
                </div>
            </div> 
			<?php }else{?>
			<div class="control-group">
                <label class="control-label" for="role_id">Set role</label>
                <div class="controls">
                    <select id="role_id" name="role_id" class="">
                        {roles}
                        <option value="{role_id}" {selected} >{role}</option>
                        {/roles}
                    </select>
                </div>
				 <input type="hidden" name="user_id" value="{user_id}" />
            </div>
			<?php } ?>
        </fieldset>
        <div class="form-actions">
        	<input type="submit" id="add-new-user" class="btn btn-primary" name="add-new-user" value="Save Changes" />
        </div>
    </form>
</div>