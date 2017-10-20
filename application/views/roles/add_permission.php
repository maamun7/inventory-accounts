<div class="page-header"><h1>Add Permission</h1></div>
<div class="row span6 well">
    <form action="<?=base_url()?>cpermission/add" id="edit_role" method="post"  name="edit_role" enctype="multypart/formdata">
		<fieldset>
            <legend>System </legend>
            <div class="control-group">
                <label class="control-label" for="is_active">Select Group</label>
                <div class="controls">
					<select id="group_id" name="group_id" class="">
                        {groups}
                        <option value="{group_id}">{group}</option>
                        {/groups}
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="permission">Permission</label>
                <div class="controls">
                    <input type="text" placeholder="Permission Name" class="" id="permission" name="permission" value="" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="permission_alias">Permission Alias</label>
                <div class="controls">
                    <input type="text" placeholder="Permission Alias" class="" id="permission_alias" name="permission_alias" value="" />
                </div>
            </div>
        </fieldset>
		<div class="form-actions">
        	<input type="submit" id="add-new-user" class="btn btn-primary" name="add-new-user" value="Save" />
        </div>
    </form>
</div>