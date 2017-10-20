<div class="page-header"><h1> Edit role: {role}</h1></div>
<div class="row span6 well">
    <form action="<?=base_url()?>crole/edit_role/{role_id}" id="edit_role" method="post"  name="edit_role" enctype="multypart/formdata">
        
        <label class="">Role name:</label>
        <input type="text" placeholder="Role name" class="form-input fifty-percent italic check" id="role_name" name="role_name" value="{role}" />
        <div class="form-actions">
            <input type="submit" id="edit-role" class="btn btn-primary" name="edit-role" value="Update" />
        </div>
    </form>
</div>