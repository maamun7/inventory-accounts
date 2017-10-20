<div class="page-header"><h1>Add new role</h1></div>
<div class="">
    <form action="<?=base_url()?>crole/add_role" id="add_role" method="post"  name="add_role" enctype="multypart/formdata">
        
        <label class="form-label">Role name:</label>
        <input type="text" placeholder="Role name" class="form-input fifty-percent italic check" id="role_name" name="role_name" />
        <fieldset class="fifty-percent">
        	<legend class="form-label">Set permissions</legend>
        <p>
        {permissions}
        </p>
        </fieldset>
        <div class="form-actions">
			<input type="submit" id="add-role" class="btn btn-primary" name="add-role" value="Save" />
        </div>
    </form>
</div>

 